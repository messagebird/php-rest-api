<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use MessageBird\Objects\Message;

/**
 * Class Messages
 *
 * @package MessageBird\Resources
 */
class Messages extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'messages');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Message::class;
    }
}
