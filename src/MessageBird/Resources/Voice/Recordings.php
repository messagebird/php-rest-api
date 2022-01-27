<?php

namespace MessageBird\Resources\Voice;

use MessageBird\Common;
use MessageBird\Common\HttpClient;
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
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var Objects\Voice\Recording
     */
    protected $object;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->object = new Objects\Voice\Recording();
    }

    public function getObject(): Objects\Voice\Recording
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
     * @return Objects\BaseList|Objects\Voice\Recording
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
     * @throws \JsonException
     */
    public function getList(string $callId, string $legId, array $parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings",
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
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function processRequest(?string $body): Objects\Voice\Recording
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
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function read(string $callId, string $legId, string $recordingId): Objects\Voice\Recording
    {
        [, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings/$recordingId"
        );

        return $this->processRequest($body);
    }

    /**
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function delete(string $callId, string $legId, string $recordingId): Objects\Voice\Recording
    {
        [, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_DELETE,
            "calls/$callId/legs/$legId/recordings/$recordingId"
        );
        return $this->processRequest($body);
    }

    /**
     * @return mixed
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function download(string $callId, string $legId, string $recordingId)
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings/$recordingId.wav"
        );

        if ($status !== 200) {
            return $this->processRequest($body);
        }

        return $body;
    }
}
