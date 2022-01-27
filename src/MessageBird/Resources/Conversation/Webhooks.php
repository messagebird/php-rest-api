<?php

namespace MessageBird\Resources\Conversation;

use MessageBird\Common\HttpClient;
use MessageBird\Objects\Conversation\Webhook;
use MessageBird\Resources\Base;

class Webhooks extends Base
{
    public const RESOURCE_NAME = 'webhooks';

    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);

        $this->object = new Webhook();
        $this->setResourceName(self::RESOURCE_NAME);
    }
}
