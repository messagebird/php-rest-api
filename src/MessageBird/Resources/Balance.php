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

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->setObject(new Objects\Balance);
        $this->setResourceName('balance');

        parent::__construct($httpClient);
    }
}
