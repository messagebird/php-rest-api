<?php

namespace MessageBird\Resources\Voice;

use MessageBird\Common;
use MessageBird\Common\HttpClient;
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
        $this->object = new Objects\Voice\Transcription();
    }

    public function getObject(): Objects\Voice\Transcription
    {
        return $this->object;
    }

    /**
     * @deprecated
     * 
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
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
     */
    public function create(string $callId, string $legId, string $recordingId): Objects\Voice\Transcription
    {
        [, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_POST,
            "calls/$callId/legs/$legId/recordings/$recordingId/transcriptions"
        );
        return $this->processRequest($body);
    }

    /**
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function processRequest(?string $body): Objects\Voice\Transcription
    {
        try {
            $body = @json_decode($body, null, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        if ($body === null) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        if (empty($body->errors)) {
            return $this->object->loadFromStdclass($body->data[0]);
        }

        $responseError = new Common\ResponseError($body);
        throw new Exceptions\RequestException($responseError->getErrorString());
    }

    /**
     * @return Objects\BaseList|Objects\Voice\Transcription
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     * @throws \JsonException
     */
    public function getList(string $callId, string $legId, string $recordingId, array $parameters = [])
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
            $baseList->loadFromStdclass($body);

            $objectName = $this->object;

            foreach ($items as $item) {
                /** @psalm-suppress UndefinedClass */
                $object = new $objectName($this->httpClient);

                $itemObject = $object->loadFromStdclass($item);
                $baseList->items[] = $itemObject;
            }
            return $baseList;
        }

        return $this->processRequest($body);
    }

    /**
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function read(string $callId, string $legId, string $recordingId, string $transcriptionId): Objects\Voice\Transcription
    {
        [, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings/$recordingId/transcriptions/$transcriptionId"
        );

        return $this->processRequest($body);
    }

    /**
     * @return Objects\Voice\Transcription|string
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function download(string $callId, string $legId, string $recordingId, string $transcriptionId)
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
