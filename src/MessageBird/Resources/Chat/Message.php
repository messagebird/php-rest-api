<?php

namespace MessageBird\Resources\Chat;

use MessageBird\Common;
use MessageBird\Objects;
use MessageBird\Resources\Base;

/**
 * Class Message
 *
 * @package MessageBird\Resources\Chat
 */
class Message extends Base
{

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->setObject(new Objects\Chat\Message());
        $this->setResourceName('messages');

        parent::__construct($httpClient);
    }
}
