<?php

namespace MessageBird\Resources\Voice;

use GuzzleHttp\ClientInterface;

/**
 * Class CallFlows
 *
 * @package MessageBird\Resources\Voice
 */
class CallFlows extends \MessageBird\Resources\Base
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
