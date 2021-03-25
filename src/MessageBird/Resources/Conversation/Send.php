<?php

namespace MessageBird\Resources\Conversation;

use MessageBird\Common\HttpClient;
use MessageBird\Exceptions;
use MessageBird\Objects\Conversation\SendMessage;
use MessageBird\Objects\Conversation\SendMessageResult;
use MessageBird\Resources\Base;

class Send extends Base
{
    const RESOURCE_NAME = 'send';

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
     * @return \MessageBird\Objects\Balance|\MessageBird\Objects\Conversation\Conversation|\MessageBird\Objects\Hlr|\MessageBird\Objects\Lookup|\MessageBird\Objects\Message|\MessageBird\Objects\Verify|\MessageBird\Objects\VoiceMessage|null
     *
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function send($object, $query = null)
    {
        $body = json_encode($object);

        list(, , $resultBody) = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_POST,
            $this->getResourceName(),
            $query,
            $body
        );

        return $this->processRequest($resultBody);
    }
}
