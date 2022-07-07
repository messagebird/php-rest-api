<?php

namespace MessageBird\Resources\Voice;

use GuzzleHttp\ClientInterface;
use MessageBird\Objects;

/**
 * Class CallFlows
 *
 * @package MessageBird\Resources\Voice
 */
class CallFlows extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'call-flows');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\Voice\CallFlow::class;
    }
}
