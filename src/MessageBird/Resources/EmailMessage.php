<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use MessageBird\Objects;

/**
 * Class EmailMessage
 *
 * @package MessageBird\Resources
 */
class EmailMessage extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'verify/messages/email');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\EmailMessage::class;
    }
}
