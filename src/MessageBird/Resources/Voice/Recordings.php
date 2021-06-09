<?php

namespace MessageBird\Resources\Voice;

use MessageBird\Common;
use MessageBird\Common\HttpClient;
use MessageBird\Exceptions\RequestException;
use MessageBird\Exceptions\ServerException;
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
        $this->setObject(new Objects\Voice\Recording());
    }

    /**
     * @return Objects\Voice\Recording
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
     * @param array $parameters
     *
     * @return Objects\BaseList|Objects\Voice\Recording
     */
    public function getList($callId, $legId, $parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings",
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
     * @return Objects\Voice\Recording
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
    public function read($callId, $legId, $recordingId): Objects\Voice\Recording
    {
        [, , $body] = $this->httpClient->performHttpRequest(HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings/$recordingId");

        return $this->processRequest($body);
    }

    /**
     * @param string $callId
     * @param string $legId
     * @param string $recordingId
     */
    public function delete($callId, $legId, $recordingId): Objects\Voice\Recording
    {
        [, , $body] = $this->httpClient->performHttpRequest(HttpClient::REQUEST_DELETE,
            "calls/$callId/legs/$legId/recordings/$recordingId");
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
        [$status, , $body] = $this->httpClient->performHttpRequest(HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId/recordings/$recordingId.wav");

        if ($status !== 200) {
            return $this->processRequest($body);
        }

        return $body;
    }
}
