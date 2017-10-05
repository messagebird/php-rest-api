<?php

namespace MessageBird\Resources\Voice;

use MessageBird\Common;
use MessageBird\Exceptions;
use MessageBird\Objects;

/**
 * Class Recordings
 *
 * @package MessageBird\Resources\Voice
 */
class Recordings
{
    /**
     * @var \MessageBird\Common\HttpClient
     */
    protected $HttpClient;

    /**
     * @var Objects\Voice\Recording
     */
    protected $Object;

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->HttpClient = $HttpClient;
        $this->setObject(new Objects\Voice\Recording());
    }

    /**
     * @param $Object
     */
    public function setObject($Object)
    {
        $this->Object = $Object;
    }

    /**
     * @return Objects\Voice\Recording
     */
    public function getObject()
    {
        return $this->Object;
    }

    /**
     * @param string $callId
     * @param string $legId
     * @param array  $parameters
     *
     * @return Objects\Voice\Recording
     */
    public function getList($callId, $legId, $parameters = array())
    {
        list($status, , $body) = $this->HttpClient->performHttpRequest(
            Common\HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings",
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
    public function read($callId, $legId, $recordingId)
    {
        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, "calls/$callId/legs/$legId/recordings/$recordingId");

        return $this->processRequest($body);
    }

    /**
     * @param string $callId
     * @param string $legId
     *
     * @return self|string
     */
    public function download($callId, $legId, $recordingId)
    {
        list($status, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, "calls/$callId/legs/$legId/recordings/$recordingId.wav");

        if ($status !== 200) {
            return $this->processRequest($body);
        }

        return $body;
    }

    /**
     * @param string $body
     *
     * @return Objects\Voice\Recording
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
