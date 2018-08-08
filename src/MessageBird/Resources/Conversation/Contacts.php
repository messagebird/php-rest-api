<?php

namespace MessageBird\Resources\Conversation;

use MessageBird\Common\HttpClient;
use MessageBird\Objects\Conversation\Contact;
use MessageBird\Resources\Base;

class Contacts extends Base
{
    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);

        $this->setObject(new Contact());
    }
}
