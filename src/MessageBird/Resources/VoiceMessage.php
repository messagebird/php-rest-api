<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use MessageBird\Objects;

/**
 * Class VoiceMessage
 *
 * @package MessageBird\Resources
 */
class VoiceMessage extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'voicemessages');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\VoiceMessage::class;
    }
}
