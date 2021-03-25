<?php

namespace MessageBird\Resources\Voice;

use MessageBird\Common;
use MessageBird\Exceptions;
use MessageBird\Objects;

/**
 * Class Legs
 *
 * @package MessageBird\Resources\Voice
 */
class Legs
{
    /**
     * @var \MessageBird\Common\HttpClient
     */
    protected $httpClient;

    /**
     * @var Objects\Voice\Leg
     */
    protected $object;

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->setObject(new Objects\Voice\Leg());
    }

    /**
     * @param mixed $object
     *
     * @return void
     */
    public function setObject($object): void
    {
        $this->object = $object;
    }

    /**
     * @return Objects\Voice\Leg
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param string      $callId
     * @param array $parameters
     *
     * @return Objects\BaseList|Objects\Voice\Leg
     */
    public function getList($callId, $parameters = [])
    {
        list($status, , $body) = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_GET,
            "calls/$callId/legs",
            $parameters
        );

        if ($status === 200) {
            $body = json_decode($body);

            $items = $body->data;
            unset($body->data);

            $baseList = new Objects\BaseList();
            $baseList->loadFromArray($body);

            $objectName = $this->object;

            foreach ($items as $item) {
                /** @psalm-suppress UndefinedClass */
                $object = new $objectName($this->httpClient);

                $itemObject = $object->loadFromArray($item);
                $baseList->items[] = $itemObject;
            }
            return $baseList;
        }

        return $this->processRequest($body);
    }

    /**
     * @param string $callId
     * @param string $legId
     *
     * @return Objects\Voice\Leg
     */
    public function read($callId, $legId): Objects\Voice\Leg
    {
        list(, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, "calls/$callId/legs/$legId");

        return $this->processRequest($body);
    }

    /**
     * @param string $body
     *
     * @return Objects\Voice\Leg
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function processRequest($body)
    {
        $body = @json_decode($body);

        if ($body === null || $body === false) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        if (empty($body->errors)) {
            return $this->object->loadFromArray($body->data[0]);
        }

        $responseError = new Common\ResponseError($body);
        throw new Exceptions\RequestException($responseError->getErrorString());
    }
}
