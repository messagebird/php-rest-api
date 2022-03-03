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
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->object = new Objects\VoiceMessage();
        $this->setResourceName('voicemessages');

        parent::__construct($httpClient);
    }
}
