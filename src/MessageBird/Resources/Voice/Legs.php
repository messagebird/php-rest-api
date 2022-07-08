<?php

namespace MessageBird\Resources\Voice;

use GuzzleHttp\ClientInterface;
use JsonMapper;
use MessageBird\Common\HttpClient;
use MessageBird\Objects;
use MessageBird\Resources\Base;

/**
 * Class Legs
 *
 * @package MessageBird\Resources\Voice
 */
class Legs extends Base
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
        return Objects\Voice\Leg::class;
    }

    /**
     * @param string $callId
     * @param array $params
     * @return Objects\BaseList
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function list(string $callId, array $params = []): Objects\BaseList
    {
        $uri = $this->getResourceName() . '/' . $callId . '/legs';
        $response = $this->httpClient->request(HttpClient::REQUEST_GET, $uri);

        return $this->handleListResponse($response);
    }

    /**
     * @param string $callId
     * @param string $legId
     * @return Objects\Voice\Leg|Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     * @throws \JsonException
     */
    public function read(string $callId, string $legId): Objects\Voice\Leg
    {
        $uri = $this->getResourceName() . '/' . $callId . '/legs/' . $legId;
        $response = $this->httpClient->request(HttpClient::REQUEST_GET, $uri);

        return $this->handleCreateResponse($response);
    }
}
