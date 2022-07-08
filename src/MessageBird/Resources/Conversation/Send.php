<?php

namespace MessageBird\Resources\Conversation;

use GuzzleHttp\ClientInterface;
use JsonMapper;
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
     * @param JsonMapper $jsonMapper
     */
    public function __construct(ClientInterface $httpClient, JsonMapper $jsonMapper)
    {
        parent::__construct($httpClient, $jsonMapper, 'send');
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
     * @return \MessageBird\Objects\Base
     */
    public function send(SendMessage $object, array $query = []): \MessageBird\Objects\Base
    {
        return $this->create($object, $query);
    }
}
