<?php

namespace MessageBird\Resources;

use MessageBird\Common;
use MessageBird\Objects;

/**
 * Class Balance
 *
 * @package MessageBird\Resources
 */
class Balance extends Base
{
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->object = new Objects\Balance();
        $this->setResourceName('balance');

        parent::__construct($httpClient);
    }
}
