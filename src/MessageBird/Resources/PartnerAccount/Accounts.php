<?php

namespace MessageBird\Resources\PartnerAccount;

use GuzzleHttp\ClientInterface;
use JsonMapper;
use MessageBird\Common\HttpClient;
use MessageBird\Objects\Arrayable;
use MessageBird\Objects\PartnerAccount\Account;
use MessageBird\Resources\Base;

/**
 * Class Accounts
 *
 * @package MessageBird\Resources
 *
 * @method Account create(Arrayable $params, array $query = null)
 */
class Accounts extends Base
{
    /**
     * @param ClientInterface $httpClient
     * @param JsonMapper $jsonMapper
     */
    public function __construct(ClientInterface $httpClient, JsonMapper $jsonMapper)
    {
        parent::__construct($httpClient, $jsonMapper, 'child-accounts');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Account::class;
    }

    /**
     * @param string $id
     * @param Arrayable $params
     * @return \MessageBird\Objects\Base|Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function update(string $id, Arrayable $params): Account
    {
        $uri = $this->getResourceName() . '/' . $id;
        $response = $this->httpClient->request(HttpClient::REQUEST_PATCH, $uri, [
            'body' => $params->toArray()
        ]);

        return $this->handleCreateResponse($response);
    }
}
