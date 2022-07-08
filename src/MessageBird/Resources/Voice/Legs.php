<?php

namespace MessageBird\Resources\Voice;

use GuzzleHttp\ClientInterface;
use MessageBird\Common\HttpClient;
use MessageBird\Objects;

/**
 * Class Legs
 *
 * @package MessageBird\Resources\Voice
 */
class Legs extends \MessageBird\Resources\Base
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
        return Objects\Voice\Leg::class;
    }

    /**
     * @param string $callId
     * @param array $params
     * @return Objects\BaseList
     * @throws \GuzzleHttp\Exception\GuzzleException
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
     */
    public function read(string $callId, string $legId): Objects\Voice\Leg
    {
        $uri = $this->getResourceName() . '/' . $callId . '/legs/' . $legId;
        $response = $this->httpClient->request(HttpClient::REQUEST_GET, $uri);

        return $this->handleCreateResponse($response);
    }
}
