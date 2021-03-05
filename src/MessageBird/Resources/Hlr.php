<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;

/**
 * Class Hlr
 *
 * @package MessageBird\Resources
 */
class Hlr extends Base
{

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->setObject(new Objects\Hlr);
        $this->setResourceName('hlr');

        parent::__construct($httpClient);
    }
}
