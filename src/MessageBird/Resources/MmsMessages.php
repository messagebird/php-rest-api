<?php

namespace MessageBird\Resources;

use MessageBird\Common;
use MessageBird\Objects;

/**
 * Class MmsMessages
 *
 * @package MessageBird\Resources
 */
class MmsMessages extends Base
{

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->setObject(new Objects\MmsMessage());
        $this->setResourceName('mms');

        parent::__construct($httpClient);
    }
}
