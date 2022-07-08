<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use JsonMapper;
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
     * @param JsonMapper $jsonMapper
     */
    public function __construct(ClientInterface $httpClient, JsonMapper $jsonMapper)
    {
        parent::__construct($httpClient, $jsonMapper, 'available-phone-numbers');
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
