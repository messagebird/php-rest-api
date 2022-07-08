<?php

namespace MessageBird\Resources;

use GuzzleHttp\ClientInterface;
use MessageBird\Objects\Arrayable;
use MessageBird\Objects\DeleteResponse;
use MessageBird\Objects\Messages\Message;

/**
 * Class Messages
 *
 * @package MessageBird\Resources
 *
 * @method Message create(Arrayable $params, array $query = null)
 * @method Message updateBasic(string $id, Arrayable $params)
 * @method \MessageBird\Objects\Messages\Messages list(array $params = [])
 * @method Message read(string $id, array $params = [])
 * @method DeleteResponse delete(string $id)
 */
class Messages extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'messages');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Message::class;
    }
}
