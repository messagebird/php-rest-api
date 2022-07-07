<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;

/**
 * Class Hlr
 *
 * @package MessageBird\Resources
 */
class Hlr extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'hlr');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return \MessageBird\Objects\Hlr::class;
    }
}
