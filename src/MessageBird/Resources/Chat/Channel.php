<?php

namespace MessageBird\Resources\Chat;

use MessageBird\Objects;
use MessageBird\Common;
use MessageBird\Resources\Base;

/**
 * Class Channel
 *
 * @package MessageBird\Resources\Chat
 */
class Channel extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {

        $this->setObject(new Objects\Chat\Channel());
        $this->setResourceName('channels');

        parent::__construct($HttpClient);
    }
}
