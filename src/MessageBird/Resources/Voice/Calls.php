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

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {

        $this->setObject(new Objects\Voice\Call());
        $this->setResourceName('calls');

        parent::__construct($HttpClient);
    }
}
