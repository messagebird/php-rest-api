<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use JsonMapper;
use MessageBird\Common\HttpClient;
use MessageBird\Objects;
use MessageBird\Objects\Arrayable;

/**
 * Class Verify
 *
 * @package MessageBird\Resources
 */
class Verify extends Base
{
    /**
     * @param ClientInterface $httpClient
     * @param JsonMapper $jsonMapper
     */
    public function __construct(ClientInterface $httpClient, JsonMapper $jsonMapper)
    {
        parent::__construct($httpClient, $jsonMapper, 'verify');
    }

    /**
     * @return Objects\Verify|Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    public function create(Arrayable $params, array $query = []): Objects\Verify
    {
        $response = $this->httpClient->request(
            HttpClient::REQUEST_POST,
            $this->getResourceName(),
            ['body' => array_merge($params->toArray(), $query)]
        );

        return $this->handleCreateResponse($response);
    }

    /**
     * @param string $id
     * @param string $token
     *
     * @return Objects\Verify|Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     * @throws \JsonException
     */
    public function verify(string $id, string $token): Objects\Verify
    {
        $uri = $this->getResourceName() . '/' . $id . '?token=' . $token;

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
