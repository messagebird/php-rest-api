<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use JsonMapper;
use MessageBird\Common\HttpClient;
use MessageBird\Objects;
use MessageBird\Objects\Arrayable;

/**
 * Class PhoneNumbers
 *
 * @package MessageBird\Resources
 */
class PhoneNumbers extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient, JsonMapper $jsonMapper)
    {
        parent::__construct($httpClient, $jsonMapper, 'phone-numbers');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\Number::class;
    }

    /**
     * @param string $id
     * @param Arrayable $params
     * @return Objects\Number|Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     * @throws \JsonException
     */
    public function update(string $id, Arrayable $params): Objects\Number
    {
        $uri = $this->getResourceName() . '/' . $id;
        $response = $this->httpClient->request(HttpClient::REQUEST_PATCH, $uri, [
            'body' => $params->toArray()
        ]);

        return $this->handleCreateResponse($response);
    }
}
