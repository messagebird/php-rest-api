<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use InvalidArgumentException;
use MessageBird\Common;
use MessageBird\Common\HttpClient;
use MessageBird\Exceptions\AuthenticateException;
use MessageBird\Exceptions\HttpException;
use MessageBird\Exceptions\RequestException;
use MessageBird\Exceptions\ServerException;
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
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'lookup');
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
     */
    public function read(string $phoneNumber, string $countryCode = null): Objects\Lookup
    {
        if ($countryCode !== null) {
            $query = ["countryCode" => $countryCode];
        }

        $uri = $this->getResourceName() . '/' . $phoneNumber . '?' . http_build_query(["countryCode" => $countryCode]);

        $response = $this->httpClient->request(HttpClient::REQUEST_GET, $uri);

        return $this->handleCreateResponse($response);
    }
}
