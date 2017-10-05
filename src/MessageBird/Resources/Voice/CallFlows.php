<?php

namespace MessageBird\Resources\Voice;

use MessageBird\Common;
use MessageBird\Objects;

/**
 * Class CallFlows
 *
 * @package MessageBird\Resources\Voice
 */
class CallFlows extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {

        $this->setObject(new Objects\Voice\CallFlow());
        $this->setResourceName('call-flows');

        parent::__construct($HttpClient);
    }
}
