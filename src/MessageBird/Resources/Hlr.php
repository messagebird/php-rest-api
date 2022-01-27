<?php

namespace MessageBird\Resources;

use MessageBird\Common;
use MessageBird\Objects;

/**
 * Class Hlr
 *
 * @package MessageBird\Resources
 */
class Hlr extends Base
{
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->object = new Objects\Hlr();
        $this->setResourceName('hlr');

        parent::__construct($httpClient);
    }
}
