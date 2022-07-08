<?php

namespace MessageBird\Resources\Voice;

use GuzzleHttp\ClientInterface;
use JsonMapper;
use MessageBird\Objects;
use MessageBird\Resources\Base;

/**
 * Class Calls
 *
 * @package MessageBird\Resources\Voice
 */
class Calls extends Base
{
    /**
     * @param ClientInterface $httpClient
     * @param JsonMapper $jsonMapper
     */
    public function __construct(ClientInterface $httpClient, JsonMapper $jsonMapper)
    {
        parent::__construct($httpClient, $jsonMapper, 'calls');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\Voice\Call::class;
    }
}
