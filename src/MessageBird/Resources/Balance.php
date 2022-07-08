<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
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
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'balance');
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
