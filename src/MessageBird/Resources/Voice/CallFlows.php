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
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {

        $this->setObject(new Objects\Voice\CallFlow());
        $this->setResourceName('call-flows');

        parent::__construct($httpClient);
    }
}
