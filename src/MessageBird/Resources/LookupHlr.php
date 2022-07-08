<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use InvalidArgumentException;
use JsonMapper;
use MessageBird\Common\HttpClient;
use MessageBird\Objects;
use MessageBird\Objects\Arrayable;

/**
 * Class LookupHlr
 *
 * @package MessageBird\Resources
 */
class LookupHlr extends Base
{
    /**
     * @param ClientInterface $httpClient
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
        return Objects\Hlr::class;
    }

    /**
     * @param string $phoneNumber
     * @param string|null $reference
     * @param string|null $countryCode
     * @return Objects\Hlr|Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    public function create(string $phoneNumber, string $reference = null, string $countryCode = null): Objects\Hlr
    {
        $uri = "{$this->getResourceName()}/$phoneNumber/hlr";

        $body = [];

        if ($reference !== null) {
            $body['reference'] = $reference;
        }

        if ($countryCode !== null) {
            $body['countryCode'] = $countryCode;
        }

        $response = $this->httpClient->request(HttpClient::REQUEST_POST, $uri, [
            'body' => $body
        ]);

        return $this->handleCreateResponse($response);
    }

    /**
     * @param mixed $phoneNumber
     * @param string|null $countryCode
     * @return Objects\Hlr|Objects\Base
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     * @throws \JsonMapper_Exception
     */
    public function read(string $phoneNumber, string $countryCode = null): Objects\Hlr
    {
        $uri = "{$this->getResourceName()}/$phoneNumber/hlr";

        if ($countryCode !== null) {
            $uri .= "?countryCode=$countryCode";
        }

        $response = $this->httpClient->request(HttpClient::REQUEST_GET, $uri);

        return $this->handleCreateResponse($response);
    }
}
