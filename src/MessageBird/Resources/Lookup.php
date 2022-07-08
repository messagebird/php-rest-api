<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use JsonMapper;
use MessageBird\Common\HttpClient;
use MessageBird\Objects;

/**
 * Class Verify
 *
 * @package MessageBird\Resources
 */
class Lookup extends Base
{
    /**
     * @param ClientInterface $httpClient
     * @param JsonMapper $jsonMapper
     */
    public function __construct(ClientInterface $httpClient, JsonMapper $jsonMapper)
    {
        parent::__construct($httpClient, $jsonMapper, 'lookup');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\Lookup::class;
    }

    /**
     * @param string|int $phoneNumber
     * @param string|null $countryCode
     *
     * @return Objects\Lookup|Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     * @throws \JsonException
     */
    public function read(string $phoneNumber, string $countryCode = null): Objects\Lookup
    {
        $uri = "{$this->getResourceName()}/$phoneNumber";

        if ($countryCode !== null) {
            $uri .= "?countryCode=$countryCode";
        }

        $response = $this->httpClient->request(HttpClient::REQUEST_GET, $uri);

        return $this->handleCreateResponse($response);
    }
}
