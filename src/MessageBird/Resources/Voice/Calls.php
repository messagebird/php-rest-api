<?php

namespace MessageBird\Resources\Voice;

use GuzzleHttp\ClientInterface;
use JsonMapper;
use MessageBird\Common\HttpClient;
use MessageBird\Objects;
use MessageBird\Objects\Arrayable;
use MessageBird\Objects\BaseList;
use MessageBird\Resources\Base;

/**
 * Class Calls
 *
 * @package MessageBird\Resources\Voice
 */
class Calls extends Base
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
        return Objects\Voice\Call::class;
    }

    /**
     * @param array $params
     * @return Objects\Voice\Calls
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function list(array $params = []): Objects\Voice\Calls
    {
        $uri = $this->getResourceName() . '?' . http_build_query($params);
        $response = $this->httpClient->request(HttpClient::REQUEST_GET, $uri);

        $responseArray = json_decode($response->getBody(), true);

        $list = new Objects\Voice\Calls();
        $list->_links = $responseArray['_links'] ?? [];
        $list->pagination = $responseArray['pagination'] ?? [];

        $list->data = [];

        foreach ($responseArray['data'] as $item) {
            $list->data[] = $this->getJsonMapper()->map($item, new ($this->responseClass()));
        }

        return $list;
    }

    /**
     * @param string $id
     * @param array $params
     * @return Objects\Base|Objects\Voice\Call
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function read(string $id, array $params = []): Objects\Voice\Call
    {
        $uri = $this->getResourceName() . '/' . $id . '?' . http_build_query($params);
        $response = $this->httpClient->request(HttpClient::REQUEST_GET, $uri);

        $responseArray = json_decode($response->getBody()->getContents(), true);

        return $this->getJsonMapper()->map($responseArray['data'], new ($this->responseClass()));
    }

    /**
     * @param Arrayable $params
     * @return Objects\Base|Objects\Voice\Call
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(Arrayable $params): Objects\Voice\Call
    {
        $response = $this->httpClient->request(HttpClient::REQUEST_POST, $this->getResourceName(), [
            'body' => $params->toArray()
        ]);

        $responseArray = json_decode($response->getBody()->getContents(), true);

        return $this->getResourceName()->map($responseArray['data'], new ($this->responseClass()));
    }
}
