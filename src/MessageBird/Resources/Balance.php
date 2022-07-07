<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use MessageBird\Objects;

/**
 * Class Balance
 *
 * @package MessageBird\Resources
 */
class Balance extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'balance');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Objects\Balance::class;
    }
}
