<?php

namespace MessageBird\Resources\Conversation;

use GuzzleHttp\ClientInterface;
use MessageBird\Objects\Conversation\SendMessage;
use MessageBird\Objects\Conversation\SendMessageResult;
use MessageBird\Resources\Base;

/**
 *
 */
class Send extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'send');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return SendMessageResult::class;
    }

    /**
     * Starts a conversation or adding a message to the conversation when a conversation with the contact already exist.
     *
     * @param SendMessage $object
     * @param array $query
     * @return Base
     */
    public function send(SendMessage $object, array $query = []): Base
    {
        return $this->create($object, $query);
    }
}
