<?php

namespace MessageBird\Resources\Voice;

use GuzzleHttp\ClientInterface;
use JsonMapper;
use MessageBird\Objects\Voice\CallFlow;
use MessageBird\Resources\Base;

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
    public function __construct(ClientInterface $httpClient, JsonMapper $jsonMapper)
    {
        parent::__construct($httpClient, $jsonMapper, 'call-flows');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return CallFlow::class;
    }
}
