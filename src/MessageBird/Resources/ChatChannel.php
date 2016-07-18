<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;

/**
 * Class ChatChannel
 *
 * @package MessageBird\Resources
 */
class ChatChannel extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     * @internal param $resourceName
     */
    public function __construct(Common\HttpClient $HttpClient)
    {

        $this->setObject(new Objects\ChatChannel());
        $this->setResourceName('channels');

        parent::__construct($HttpClient);
    }
}
