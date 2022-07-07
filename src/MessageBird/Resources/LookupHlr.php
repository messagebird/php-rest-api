<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use InvalidArgumentException;
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
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'lookup');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\Hlr::class;
    }

    /**
     * @param Objects\Hlr|Arrayable $hlr
     * @param array $query
     * @return Objects\Hlr|Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function create(Arrayable $hlr, array $query = []): Objects\Hlr
    {
        if (empty($hlr->msisdn)) {
            throw new InvalidArgumentException('The phone number ($hlr->msisdn) cannot be empty.');
        }

        $uri = $this->getResourceName() . '/' . ($hlr->msisdn) . '/hlr';

        if (empty($query) === false) {
            $uri .= '?' . http_build_query($query);
        }

        $response = $this->httpClient->request(HttpClient::REQUEST_POST, $uri, [
            'body' => $hlr->toArray()
        ]);

        return $this->handleCreateResponse($response);
    }

    /**
     * @param mixed $phoneNumber
     * @param array $query
     * @return Objects\Hlr|Objects\Base
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function read(string $phoneNumber, array $query = []): Objects\Hlr
    {
        if (empty($phoneNumber)) {
            throw new InvalidArgumentException('The phone number cannot be empty.');
        }

        $uri = $this->getResourceName() . '/' . $phoneNumber . '/hlr' . '?' . http_build_query($query);

        $response = $this->httpClient->request(HttpClient::REQUEST_GET, $uri);

        return $this->handleCreateResponse($response);
    }
}
