<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use JsonMapper;
use MessageBird\Objects;

/**
 * Class MmsMessages
 *
 * @package MessageBird\Resources
 */
class MmsMessages extends Base
{
    /**
     * @param ClientInterface $httpClient
     * @param JsonMapper $jsonMapper
     */
    public function __construct(ClientInterface $httpClient, JsonMapper $jsonMapper)
    {
        parent::__construct($httpClient, $jsonMapper, 'mms');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\MmsMessage::class;
    }
}
