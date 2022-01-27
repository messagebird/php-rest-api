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
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->object = new Objects\MmsMessage();
        $this->setResourceName('mms');

        parent::__construct($httpClient);
    }
}
