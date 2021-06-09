<?php

namespace MessageBird\Resources\Voice;

use MessageBird\Common;
use MessageBird\Common\HttpClient;
use MessageBird\Exceptions\RequestException;
use MessageBird\Exceptions\ServerException;
use MessageBird\Objects;

/**
 * Class Legs
 *
 * @package MessageBird\Resources\Voice
 */
class Legs
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var Objects\Voice\Leg
     */
    protected $object;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->setObject(new Objects\Voice\Leg());
    }

    /**
     * @return Objects\Voice\Leg
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param mixed $object
     */
    public function setObject($object): void
    {
        $this->object = $object;
    }

    /**
     * @param string $callId
     * @param array $parameters
     *
     * @return Objects\BaseList|Objects\Voice\Leg
     */
    public function getList($callId, $parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            "calls/$callId/legs",
            $parameters
        );

        if ($status === 200) {
            $body = json_decode($body, null, 512, JSON_THROW_ON_ERROR);

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
     * @param string $body
     *
     * @return Objects\Voice\Leg
     * @throws RequestException
     * @throws ServerException
     */
    public function processRequest($body)
    {
        $body = @json_decode($body, null, 512, JSON_THROW_ON_ERROR);

        if ($body === null || $body === false) {
            throw new ServerException('Got an invalid JSON response from the server.');
        }

        if (empty($body->errors)) {
            return $this->object->loadFromArray($body->data[0]);
        }

        $responseError = new Common\ResponseError($body);
        throw new RequestException($responseError->getErrorString());
    }

    /**
     * @param string $callId
     * @param string $legId
     */
    public function read($callId, $legId): Objects\Voice\Leg
    {
        [, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId"
        );

        return $this->processRequest($body);
    }
}
