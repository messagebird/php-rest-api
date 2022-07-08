<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use JsonMapper;
use MessageBird\Common\HttpClient;
use MessageBird\Objects;

/**
 * Class Balance
 *
 * @package MessageBird\Resources
 */
class Balance extends Base
{
    /**
     * @param ClientInterface $httpClient
     * @param JsonMapper $jsonMapper
     */
    public function __construct(ClientInterface $httpClient, JsonMapper $jsonMapper)
    {
        parent::__construct($httpClient, $jsonMapper, 'balance');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\Balance::class;
    }

    /**
     * @return Objects\Balance|Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    public function read(): Objects\Balance
    {
        return $this->handleCreateResponse(
            $this->httpClient->request(HttpClient::REQUEST_GET, $this->getResourceName())
        );
    }
}
