<?php

namespace MessageBird\Resources\Conversation;

use MessageBird\Common\HttpClient;
use MessageBird\Objects\Conversation\Content as ContentObject;
use MessageBird\Resources\Base;

class Content extends Base
{
    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);

        $this->object = new ContentObject();
    }
}
