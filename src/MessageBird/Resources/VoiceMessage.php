<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use MessageBird\Objects;
use MessageBird\Objects\Arrayable;

/**
 * Class VoiceMessage
 *
 * @package MessageBird\Resources
 *
 * @method Objects\VoiceMessage create(Arrayable $params, array $query = [])
 * @method Objects\VoiceMessage read(string $id, array $params = [])
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
