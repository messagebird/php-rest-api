<?php

namespace MessageBird\Resources\Conversation;

use MessageBird\Common\HttpClient;
use MessageBird\Exceptions;
use MessageBird\Objects\Balance;
use MessageBird\Objects\Conversation\Conversation;
use MessageBird\Objects\Conversation\SendMessage;
use MessageBird\Objects\Conversation\SendMessageResult;
use MessageBird\Objects\Hlr;
use MessageBird\Objects\Lookup;
use MessageBird\Objects\Message;
use MessageBird\Objects\Verify;
use MessageBird\Objects\VoiceMessage;
use MessageBird\Resources\Base;

class Send extends Base
{
    public const RESOURCE_NAME = 'send';

    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);

        $this->setObject(new SendMessageResult());
        $this->setResourceName(self::RESOURCE_NAME);
    }

    /**
     * Starts a conversation or adding a message to the conversation when a conversation with the contact already exist.
     *
     * @param SendMessage $object
     * @param array|null $query
     *
     * @return Balance|Conversation|Hlr|Lookup|Message|Verify|VoiceMessage|null
     *
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function send($object, $query = null)
    {
        $body = json_encode($object, \JSON_THROW_ON_ERROR);

        [, , $resultBody] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_POST,
            $this->getResourceName(),
            $query,
            $body
        );

        return $this->processRequest($resultBody);
    }
}
