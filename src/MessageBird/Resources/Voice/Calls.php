<?php

namespace MessageBird\Resources\Voice;

use MessageBird\Common;
use MessageBird\Objects;

/**
 * Class Calls
 *
 * @package MessageBird\Resources\Voice
 */
class Calls extends Base
{
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->object = new Objects\Voice\Call();
        $this->setResourceName('calls');

        parent::__construct($httpClient);
    }
}
