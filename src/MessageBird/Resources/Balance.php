<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;

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
