<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
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
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'phone-numbers');
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
