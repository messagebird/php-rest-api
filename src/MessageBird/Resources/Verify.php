<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use MessageBird\Common\HttpClient;
use MessageBird\Objects;

/**
 * Class Verify
 *
 * @package MessageBird\Resources
 */
class Verify extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'verify');
    }

    /**
     * @param string $id
     * @param string $token
     *
     * @return Objects\Verify|Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function verify(string $id, string $token): Objects\Verify
    {
        $uri = $this->getResourceName() . '/' . $id . '?' . http_build_query(['token' => $token]);

        $response = $this->httpClient->request(HttpClient::REQUEST_GET, $uri);

        return $this->handleCreateResponse($response);
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\Verify::class;
    }
}
