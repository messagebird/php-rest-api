<?php

namespace MessageBird\Resources\Voice;

use GuzzleHttp\ClientInterface;
use MessageBird\Objects;

/**
 * Class Calls
 *
 * @package MessageBird\Resources\Voice
 */
class Calls extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'calls');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\Voice\Call::class;
    }
}
