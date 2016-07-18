<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;

/**
 * Class ChatMessage
 *
 * @package MessageBird\Resources
 */
class ChatMessage extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     * @internal param $resourceName
     */
    public function __construct(Common\HttpClient $HttpClient)
    {

        $this->setObject(new Objects\ChatMessage());
        $this->setResourceName('messages');

        parent::__construct($HttpClient);
    }
}
