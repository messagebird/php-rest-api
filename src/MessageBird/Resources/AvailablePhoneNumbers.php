<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use MessageBird\Common\HttpClient;
use MessageBird\Objects;

/**
 * Class AvailablePhoneNumbers
 *
 * @package MessageBird\Resources
 */
class AvailablePhoneNumbers extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'available-phone-numbers');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\Number::class;
    }

    /**
     * @param string $countryCode
     * @param array $params
     * @return Objects\BaseList
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getList(string $countryCode, array $params = []): Objects\BaseList
    {
        $response = $this->httpClient->request(
            HttpClient::REQUEST_GET,
            "{$this->getResourceName()}/$countryCode?" . http_build_query($params)
        );

        return $this->handleListResponse($response);
    }
}
