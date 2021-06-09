<?php

namespace MessageBird\Resources\PartnerAccount;

use MessageBird\Common\HttpClient;
use MessageBird\Objects\Balance;
use MessageBird\Objects\Conversation\Conversation;
use MessageBird\Objects\Hlr;
use MessageBird\Objects\Lookup;
use MessageBird\Objects\Message;
use MessageBird\Objects\PartnerAccount\Account;
use MessageBird\Objects\Verify;
use MessageBird\Objects\VoiceMessage;
use MessageBird\Resources\Base;

class Accounts extends Base
{
    public const RESOURCE_NAME = 'child-accounts';

    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);

        $this->setObject(new Account());
        $this->setResourceName(self::RESOURCE_NAME);
    }

    /**
     * @return Balance|Conversation|Hlr|Lookup|Message|Verify|VoiceMessage|null
     */
    public function create($object, $query = null)
    {
        [, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_POST,
            self::RESOURCE_NAME,
            null,
            $object->loadToJson()
        );

        return $this->processRequest($body);
    }

    public function getList($parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            self::RESOURCE_NAME,
            $parameters
        );

        if ($status !== 200) {
            return $this->processRequest($body);
        }


        $response = json_decode($body, true, 512, \JSON_THROW_ON_ERROR);

        foreach ($response as &$singleResponse) {
            $this->getObject()->loadFromArray($singleResponse);
        }

        return $response;
    }

    /**
     * @return Balance|Conversation|Hlr|Lookup|Message|Verify|VoiceMessage|null
     */
    public function update($object, $id)
    {
        [, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_PATCH,
            sprintf('%s/%s', self::RESOURCE_NAME, $id),
            null,
            $object->loadToJson()
        );

        return $this->processRequest($body);
    }
}
