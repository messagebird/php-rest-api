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
    protected $HttpClient;

    /**
     * @var Objects\Voice\Leg
     */
    protected $Object;

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->HttpClient = $HttpClient;
        $this->setObject(new Objects\Voice\Leg());
    }

    /**
     * @param $Object
     */
    public function setObject($Object)
    {
        $this->Object = $Object;
    }

    /**
     * @return Objects\Voice\Leg
     */
    public function getObject()
    {
        return $this->Object;
    }

    /**
     * @param string      $callId
     * @param array $parameters
     *
     * @return Objects\Voice\Leg
     */
    public function getList($callId, $parameters = array())
    {
        list($status, , $body) = $this->HttpClient->performHttpRequest(
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

            $objectName = $this->Object;

            foreach ($items as $item) {
                $object = new $objectName($this->HttpClient);

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
     * @return $this->Object
     */
    public function read($callId, $legId)
    {
        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, "calls/$callId/legs/$legId");

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

        if ($body === null or $body === false) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        if (empty($body->errors)) {
            return $this->Object->loadFromArray($body->data[0]);
        }

        $ResponseError = new Common\ResponseError($body);
        throw new Exceptions\RequestException($ResponseError->getErrorString());
    }
}
