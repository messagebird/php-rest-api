<?php

namespace MessageBird\Resources\Chat;

use MessageBird\Objects;
use MessageBird\Common;
use MessageBird\Resources\Base;

/**
 * Class Contact
 *
 * @package MessageBird\Resources\Chat
 */
class Contact extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {

        $this->setObject(new Objects\Chat\Contact());
        $this->setResourceName('contacts');

        parent::__construct($HttpClient);
    }
}
