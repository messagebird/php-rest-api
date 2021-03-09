<?php

namespace MessageBird\Resources\Chat;

use MessageBird\Common;
use MessageBird\Objects;
use MessageBird\Resources\Base;

/**
 * Class Platform
 *
 * @package MessageBird\Resources\Chat
 */
class Platform extends Base
{

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {

        $this->setObject(new Objects\Chat\Platform());
        $this->setResourceName('platforms');

        parent::__construct($httpClient);
    }
}
