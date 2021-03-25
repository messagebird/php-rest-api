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
    protected $httpClient;

    /**
     * @var Objects\Voice\Recording
     */
    protected $object;

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->setObject(new Objects\Voice\Recording());
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
     * @return Objects\Voice\Recording
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param string $callId
     * @param string $legId
     * @param array  $parameters
     *
     * @return Objects\BaseList|Objects\Voice\Recording
     */
    public function getList($callId, $legId, $parameters = [])
    {
        list($status, , $body) = $this->httpClient->performHttpRequest(
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
     * @return Objects\Voice\Recording
     */
    public function read($callId, $legId, $recordingId): Objects\Voice\Recording
    {
        list(, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, "calls/$callId/legs/$legId/recordings/$recordingId");

        return $this->processRequest($body);
    }

    /**
     * @param string $callId
     * @param string $legId
     * @param string $recordingId
     *
     * @return Objects\Voice\Recording
     */
    public function delete($callId, $legId, $recordingId): Objects\Voice\Recording
    {
        list(, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_DELETE, "calls/$callId/legs/$legId/recordings/$recordingId");
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
        list($status, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, "calls/$callId/legs/$legId/recordings/$recordingId.wav");

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
