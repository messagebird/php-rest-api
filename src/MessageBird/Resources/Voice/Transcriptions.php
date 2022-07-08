<?php

namespace MessageBird\Resources\Voice;

use GuzzleHttp\ClientInterface;
use MessageBird\Common;
use MessageBird\Common\HttpClient;
use MessageBird\Exceptions;
use MessageBird\Objects;
use MessageBird\Objects\Voice\Transcription;
use Psr\Http\Message\StreamInterface;

/**
 * Class Transcriptions
 *
 * @package MessageBird\Resources\Voice
 */
class Transcriptions extends \MessageBird\Resources\Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'calls');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Transcription::class;
    }

    /**
     * @param string $callId
     * @param string $legId
     * @param string $recordingId
     *
     * @return Objects\Voice\Transcription|Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function create(string $callId, string $legId, string $recordingId): Objects\Voice\Transcription
    {
        $response = $this->httpClient->request(
            HttpClient::REQUEST_POST,
            "{$this->getResourceName()}/$callId/legs/$legId/recordings/$recordingId/transcriptions"
        );

        return $this->handleCreateResponse($response);
    }

    /**
     * @param string $callId
     * @param string $legId
     * @param string $recordingId
     * @param array $params
     * @return Objects\BaseList
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list(string $callId, string $legId, string $recordingId, array $params = []): Objects\BaseList
    {

        $uri = $this->getResourceName() . '/' . $callId . '/legs/' . $legId . '/recordings/?' . http_build_query($params);
        $response = $this->httpClient->request(
            HttpClient::REQUEST_GET,
            "{$this->getResourceName()}/$callId/legs/$legId/recordings/$recordingId/transcriptions?" . http_build_query($params)
        );

        return $this->handleListResponse($response);
    }

    /**
     * @param string $callId
     * @param string $legId
     * @param string $recordingId
     * @param string $transcriptionId
     * @return Transcription|Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function read(string $callId, string $legId, string $recordingId, string $transcriptionId): Objects\Voice\Transcription
    {
        $response = $this->httpClient->request(
            HttpClient::REQUEST_GET,
            "{$this->getResourceName()}/$callId/legs/$legId/recordings/$recordingId/transcriptions/$transcriptionId"
        );

        return $this->handleCreateResponse($response);
    }

    /**
     * @param string $callId
     * @param string $legId
     * @param string $recordingId
     * @param string $transcriptionId
     * @return StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function download(string $callId, string $legId, string $recordingId, string $transcriptionId): StreamInterface
    {
        $response = $this->httpClient->request(
            HttpClient::REQUEST_GET,
            "{$this->getResourceName()}/$callId/legs/$legId/recordings/$recordingId/transcriptions/$transcriptionId.txt"
        );

        return $response->getBody();
    }
}
