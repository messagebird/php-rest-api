<?php

namespace MessageBird\Resources\Conversation;

use MessageBird\Common\HttpClient;
use MessageBird\Objects\Conversation\Webhook;
use MessageBird\Resources\Base;

class Webhooks extends Base
{
    const RESOURCE_NAME = 'webhooks';

    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);

        $this->setObject(new Webhook());
        $this->setResourceName(self::RESOURCE_NAME);
    }
}
