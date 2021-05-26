<?php

namespace MessageBird\Resources;

use MessageBird\Common;
use MessageBird\Objects;

/**
 * Class EmailMessage
 *
 * @package MessageBird\Resources
 */
class EmailMessage extends Base
{
    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->setObject(new Objects\EmailMessage);
        $this->setResourceName('verify/messages/email');

        parent::__construct($httpClient);
    }
}
