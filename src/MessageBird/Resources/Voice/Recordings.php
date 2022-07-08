<?php

namespace MessageBird\Resources\Voice;

use GuzzleHttp\ClientInterface;
use JsonMapper;
use MessageBird\Common\HttpClient;
use MessageBird\Objects\BaseList;
use MessageBird\Objects\Voice\Recording;
use MessageBird\Resources\Base;
use Psr\Http\Message\StreamInterface;

/**
 * Class Recordings
 *
 * @package MessageBird\Resources\Voice
 */
class Recordings extends Base
{
    /**
     * @param ClientInterface $httpClient
     * @param JsonMapper $jsonMapper
     */
    public function __construct(ClientInterface $httpClient, JsonMapper $jsonMapper)
    {
        parent::__construct($httpClient, $jsonMapper, 'calls');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Recording::class;
    }

    /**
     * @param string $callId
     * @param string $legId
     * @param array $params
     * @return BaseList
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function list(string $callId, string $legId, array $params = []): BaseList
    {
        $uri = $this->getResourceName() . '/' . $callId . '/legs/' . $legId . '/recordings?' . http_build_query($params);
        $response = $this->httpClient->request(HttpClient::REQUEST_GET, $uri);

        return $this->handleListResponse($response);
    }

    /**
     * @param string $callId
     * @param string $legId
     * @param string $recordingId
     * @return Recording|\MessageBird\Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     * @throws \JsonException
     */
    public function read(string $callId, string $legId, string $recordingId): Recording
    {
        $response = $this->httpClient->request(
            HttpClient::REQUEST_GET,
            "{$this->getResourceName()}/$callId/legs/$legId/recordings/$recordingId"
        );

        return $this->handleCreateResponse($response);
    }

    /**
     * @param string $callId
     * @param string $legId
     * @param string $recordingId
     * @return Recording|\MessageBird\Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     * @throws \JsonException
     */
    public function delete(string $callId, string $legId, string $recordingId): Recording
    {
        $response = $this->httpClient->request(
            HttpClient::REQUEST_DELETE,
            "{$this->getResourceName()}/$callId/legs/$legId/recordings/$recordingId"
        );

        return $this->handleDeleteResponse($response);
    }

    /**
     * @param string $callId
     * @param string $legId
     * @param string $recordingId
     * @return StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function download(string $callId, string $legId, string $recordingId): StreamInterface
    {
        $response = $this->httpClient->request(
            HttpClient::REQUEST_GET,
            "{$this->getResourceName()}/$callId/legs/$legId/recordings/$recordingId.wav"
        );

        return $response->getBody();
    }
}
