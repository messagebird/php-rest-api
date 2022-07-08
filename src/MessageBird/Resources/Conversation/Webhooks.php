<?php

namespace MessageBird\Resources\Conversation;

use GuzzleHttp\ClientInterface;
use JsonMapper;
use MessageBird\Objects\Conversation\Webhook;
use MessageBird\Resources\Base;

class Webhooks extends Base
{
    /**
     * @param ClientInterface $httpClient
     * @param JsonMapper $jsonMapper
     */
    public function __construct(ClientInterface $httpClient, JsonMapper $jsonMapper)
    {
        parent::__construct($httpClient, $jsonMapper, 'webhooks');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Webhook::class;
    }
}
