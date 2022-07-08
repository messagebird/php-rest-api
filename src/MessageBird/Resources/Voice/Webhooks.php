<?php

namespace MessageBird\Resources\Voice;

use GuzzleHttp\ClientInterface;
use MessageBird\Objects;

/**
 * Class Webhooks
 *
 * @package MessageBird\Resources\Voice
 */
class Webhooks extends \MessageBird\Resources\Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'webhooks');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\Voice\Webhook::class;
    }
}
