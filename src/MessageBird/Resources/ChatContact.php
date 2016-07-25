<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;

/**
 * Class ChatContact
 *
 * @package MessageBird\Resources
 */
class ChatContact extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {

        $this->setObject(new Objects\ChatContact());
        $this->setResourceName('contacts');

        parent::__construct($HttpClient);
    }
}
