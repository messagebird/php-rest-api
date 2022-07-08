<?php

namespace MessageBird\Resources\Conversation;

use GuzzleHttp\ClientInterface;
use MessageBird\Objects\Conversation\Webhook;
use MessageBird\Resources\Base;

class Webhooks extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'webhooks');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Webhook::class;
    }
}
