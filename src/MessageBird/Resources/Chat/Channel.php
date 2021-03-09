<?php

namespace MessageBird\Resources\Chat;

use MessageBird\Common;
use MessageBird\Objects;
use MessageBird\Resources\Base;

/**
 * Class Channel
 *
 * @package MessageBird\Resources\Chat
 */
class Channel extends Base
{

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {

        $this->setObject(new Objects\Chat\Channel());
        $this->setResourceName('channels');

        parent::__construct($httpClient);
    }
}
