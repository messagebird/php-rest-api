<?php

namespace MessageBird\Resources\Voice;

use MessageBird\Common;
use MessageBird\Common\HttpClient;
use MessageBird\Exceptions\RequestException;
use MessageBird\Exceptions\ServerException;
use MessageBird\Objects;

/**
 * Class Transcriptions
 *
 * @package MessageBird\Resources\Voice
 */
class Transcriptions
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var Objects\Voice\Transcription
     */
    protected $object;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->setObject(new Objects\Voice\Transcription());
    }

    /**
     * @return Objects\Voice\Transcription
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
     * @param string $legId
     * @param string $recordingId
     *
     * @return Objects\Voice\Transcription
     */
    public function create($callId, $legId, $recordingId)
    {
        [, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_POST,
            "calls/$callId/legs/$legId/recordings/$recordingId/transcriptions"
        );
        return $this->processRequest($body);
    }

    /**
     * @param string $body
     *
     * @return Objects\Voice\Transcription
     * @throws RequestException
     * @throws ServerException
     */
    public function processRequest($body)
    {
        try {
            $body = @json_decode($body, null, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new ServerException('Got an invalid JSON response from the server.');
        }

        if ($body === null) {
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
     * @param string $recordingId
     * @param array $parameters
     *
     * @return Objects\BaseList|Objects\Voice\Transcription
     */
    public function getList($callId, $legId, $recordingId, $parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings/$recordingId/transcriptions",
            $parameters
        );

        if ($status === 200) {
            $body = json_decode($body, null, 512, \JSON_THROW_ON_ERROR);

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
     * @param string $legId string
     * @param string $recordingId
     * @param string $transcriptionId
     *
     * @return $this ->object
     */
    public function read($callId, $legId, $recordingId, $transcriptionId)
    {
        [, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings/$recordingId/transcriptions/$transcriptionId"
        );

        return $this->processRequest($body);
    }

    /**
     * @param string $callId string
     * @param string $legId string
     * @param string $recordingId
     * @param string $transcriptionId
     *
     * @return self|string
     */
    public function download($callId, $legId, $recordingId, $transcriptionId)
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings/$recordingId/transcriptions/$transcriptionId.txt"
        );

        if ($status !== 200) {
            return $this->processRequest($body);
        }

        return $body;
    }
}
