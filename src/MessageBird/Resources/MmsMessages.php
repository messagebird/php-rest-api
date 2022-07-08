<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
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
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'mms');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\MmsMessage::class;
    }
}
