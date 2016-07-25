<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;

/**
 * Class ChatPlatform
 *
 * @package MessageBird\Resources
 */
class ChatPlatform extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {

        $this->setObject(new Objects\ChatPlatform());
        $this->setResourceName('platforms');

        parent::__construct($HttpClient);
    }
}
