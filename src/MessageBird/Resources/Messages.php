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
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->object = new Objects\Message();
        $this->setResponseObject(new Objects\MessageResponse());
        $this->setResourceName('messages');

        parent::__construct($httpClient);
    }
}
