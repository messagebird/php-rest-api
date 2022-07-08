<?php

namespace MessageBird\Resources\Voice;

use GuzzleHttp\ClientInterface;
use JsonMapper;
use MessageBird\Objects;
use MessageBird\Resources\Base;

/**
 * Class Webhooks
 *
 * @package MessageBird\Resources\Voice
 */
class Webhooks extends Base
{
    /**
     * @param ClientInterface $httpClient
     * @param JsonMapper $jsonMapper
     */
    public function __construct(ClientInterface $httpClient, JsonMapper $jsonMapper)
    {
        parent::__construct($httpClient, $jsonMapper, 'webhooks');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\Voice\Webhook::class;
    }
}
