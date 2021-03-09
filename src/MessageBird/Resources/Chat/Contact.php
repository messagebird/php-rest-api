<?php

namespace MessageBird\Resources\Chat;

use MessageBird\Common;
use MessageBird\Objects;
use MessageBird\Resources\Base;

/**
 * Class Contact
 *
 * @package MessageBird\Resources\Chat
 */
class Contact extends Base
{

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->setObject(new Objects\Chat\Contact());
        $this->setResourceName('contacts');

        parent::__construct($httpClient);
    }
}
