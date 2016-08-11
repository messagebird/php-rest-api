<?php

namespace MessageBird\Resources\Chat;

use MessageBird\Objects;
use MessageBird\Common;
use MessageBird\Resources\Base;

/**
 * Class Message
 *
 * @package MessageBird\Resources\Chat
 */
class Message extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {

        $this->setObject(new Objects\Chat\Message());
        $this->setResourceName('messages');

        parent::__construct($HttpClient);
    }
}
