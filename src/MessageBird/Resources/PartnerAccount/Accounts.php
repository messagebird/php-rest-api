<?php

namespace MessageBird\Resources\PartnerAccount;

use MessageBird\Common\HttpClient;
use MessageBird\Objects\PartnerAccount\Account;
use MessageBird\Resources\Base;

class Accounts extends Base
{
    const RESOURCE_NAME = 'child-accounts';

    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);

        $this->setObject(new Account());
        $this->setResourceName(self::RESOURCE_NAME);
    }

    public function create($object, $query = null)
    {
        list(, , $body) = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_POST,
            self::RESOURCE_NAME,
            null,
            $object->loadToJson()
        );

        return $this->processRequest($body);
    }

    public function getList($parameters = [])
    {
        list($status, , $body) = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            self::RESOURCE_NAME,
            $parameters
        );

        if ($status !== 200) {
            return $this->processRequest($body);
        }


        $response = json_decode($body, true);

        foreach ($response as &$item) {
            $item = $this->getObject()->loadFromArray($item);
        }

        return $response;
    }

    public function update($object, $id)
    {
        list(, , $body) = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_PATCH,
            sprintf('%s/%s', self::RESOURCE_NAME, $id),
            null,
            $object->loadToJson()
        );

        return $this->processRequest($body);
    }
}
