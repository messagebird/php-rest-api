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
    protected $httpClient;

    /**
     * @var Objects\Voice\Transcription
     */
    protected $object;

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->setObject(new Objects\Voice\Transcription());
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
     * @return Objects\Voice\Transcription
     */
    public function getObject()
    {
        return $this->object;
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
        list(, , $body) = $this->httpClient->performHttpRequest(
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
     * @return Objects\BaseList|Objects\Voice\Transcription
     */
    public function getList($callId, $legId, $recordingId, $parameters = [])
    {
        list($status, , $body) = $this->httpClient->performHttpRequest(
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
     * @param string $callId string
     * @param string $legId  string
     * @param string $recordingId
     * @param string $transcriptionId
     *
     * @return $this ->object
     */
    public function read($callId, $legId, $recordingId, $transcriptionId)
    {
        list(, , $body) = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings/$recordingId/transcriptions/$transcriptionId"
        );

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
        list($status, , $body) = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings/$recordingId/transcriptions/$transcriptionId.txt"
        );

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
