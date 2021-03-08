<?php

namespace MessageBird\Resources;

use MessageBird\Common;
use MessageBird\Objects;

/**
 * Class Messages
 *
 * @package MessageBird\Resources
 */
class Messages extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->setObject(new Objects\Message);
        $this->setResourceName('messages');

        parent::__construct($HttpClient);
    }
}
