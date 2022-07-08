<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use MessageBird\Objects\Arrayable;

/**
 * Class Hlr
 *
 * @package MessageBird\Resources
 *
 * @method \MessageBird\Objects\Hlr create(Arrayable $params, array $query = [])
 * @method \MessageBird\Objects\Hlr read(string $id, array $params = [])
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
