<?php

namespace MessageBird\Resources\Voice;

use MessageBird\Common;
use MessageBird\Exceptions;
use MessageBird\Objects;

/**
 * Class Transcriptions
 *
 * @package MessageBird\Resources\Voice
 */
class Transcriptions
{
    /**
     * @var \MessageBird\Common\HttpClient
     */
    protected $HttpClient;

    /**
     * @var Objects\Voice\Transcription
     */
    protected $Object;

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->HttpClient = $HttpClient;
        $this->setObject(new Objects\Voice\Transcription());
    }

    /**
     * @param $Object
     */
    public function setObject($Object)
    {
        $this->Object = $Object;
    }

    /**
     * @return Objects\Voice\Transcription
     */
    public function getObject()
    {
        return $this->Object;
    }

    /**
     * @param string                      $callId
     * @param string                      $legId
     * @param string                      $recordingId
     *
     * @return Objects\Voice\Transcription
     */
    public function create($callId, $legId, $recordingId)
    {
        list(, , $body) = $this->HttpClient->performHttpRequest(
            Common\HttpClient::REQUEST_POST,
            "calls/$callId/legs/$legId/recordings/$recordingId/transcriptions"
        );
        return $this->processRequest($body);
    }

    /**
     * @param string $callId
     * @param string $legId
     * @param string $recordingId
     * @param array  $parameters
     *
     * @return Objects\Voice\Transcription
     */
    public function getList($callId, $legId, $recordingId, $parameters = array())
    {
        list($status, , $body) = $this->HttpClient->performHttpRequest(
            Common\HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings/$recordingId/transcriptions",
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
     * @param string $callId string
     * @param string $legId  string
     * @param string $recordingId
     * @param string $transcriptionId
     *
     * @return $this ->Object
     */
    public function read($callId, $legId, $recordingId, $transcriptionId)
    {
        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings/$recordingId/transcriptions/$transcriptionId");

        return $this->processRequest($body);
    }

    /**
     * @param string $callId string
     * @param string $legId  string
     * @param string $recordingId
     * @param string $transcriptionId
     *
     * @return self|string
     */
    public function download($callId, $legId, $recordingId, $transcriptionId)
    {
        list($status, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings/$recordingId/transcriptions/$transcriptionId.txt");

        if ($status !== 200) {
            return $this->processRequest($body);
        }

        return $body;
    }

    /**
     * @param string $body
     *
     * @return Objects\Voice\Transcription
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
