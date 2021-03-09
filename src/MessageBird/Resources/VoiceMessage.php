<?php

namespace MessageBird\Resources;

use MessageBird\Common;
use MessageBird\Objects;

/**
 * Class VoiceMessage
 *
 * @package MessageBird\Resources
 */
class VoiceMessage extends Base
{

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->setObject(new Objects\VoiceMessage);
        $this->setResourceName('voicemessages');

        parent::__construct($httpClient);
    }
}
