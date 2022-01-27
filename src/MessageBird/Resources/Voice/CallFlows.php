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
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->object = new Objects\Voice\CallFlow();
        $this->setResourceName('call-flows');

        parent::__construct($httpClient);
    }
}
