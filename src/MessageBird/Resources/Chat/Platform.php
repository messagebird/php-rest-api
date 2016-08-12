<?php

namespace MessageBird\Resources\Chat;

use MessageBird\Objects;
use MessageBird\Common;
use MessageBird\Resources\Base;

/**
 * Class Platform
 *
 * @package MessageBird\Resources\Chat
 */
class Platform extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {

        $this->setObject(new Objects\Chat\Platform());
        $this->setResourceName('platforms');

        parent::__construct($HttpClient);
    }
}
