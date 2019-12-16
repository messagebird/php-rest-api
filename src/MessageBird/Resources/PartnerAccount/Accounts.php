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

        list($status, , $body) = $this->HttpClient->performHttpRequest(
            HttpClient::REQUEST_POST,
            self::RESOURCE_NAME,
            null,
            $object->loadToJson()
        );

        var_dump($status);
        var_dump($body);

        return $this->processRequest($body);
    }

    public function getList($parameters = [])
    {
        list($status, , $body) = $this->HttpClient->performHttpRequest(
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
}
