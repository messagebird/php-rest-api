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
use MessageBird\Exceptions;

class Accounts extends Base
{
    public const RESOURCE_NAME = 'child-accounts';

    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);

        $this->object = new Account();
        $this->setResourceName(self::RESOURCE_NAME);
    }

    /**
     * @param $object
     * @param array|null $query
     * @return Balance|Conversation|Hlr|Lookup|Message|Verify|VoiceMessage|null
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function create($object, ?array $query = null)
    {
        [, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_POST,
            self::RESOURCE_NAME,
            null,
            $object->loadToJson()
        );

        return $this->processRequest($body);
    }

    /**
     * @return array|Balance|\MessageBird\Objects\BaseList|Conversation|Hlr|Lookup|Message|\MessageBird\Objects\MessageResponse|Verify|VoiceMessage|null
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     * @throws \JsonException
     */
    public function getList(?array $parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            self::RESOURCE_NAME,
            $parameters
        );

        if ($status !== 200) {
            return $this->processRequest($body);
        }

        $response = json_decode($body, false, 512, \JSON_THROW_ON_ERROR);

        $return = [];
        foreach ($response as &$singleResponse) {
            $object = clone $this->getObject();
            $return[] = $object->loadFromStdclass($singleResponse);
        }

        return $return;
    }

    /**
     * @param $object
     * @param $id
     * @return Balance|Conversation|Hlr|Lookup|Message|Verify|VoiceMessage|null
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
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
