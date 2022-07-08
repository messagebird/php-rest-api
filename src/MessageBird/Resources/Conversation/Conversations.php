<?php

namespace MessageBird\Resources\Conversation;

use GuzzleHttp\ClientInterface;
use JsonMapper;
use MessageBird\Common\HttpClient;
use MessageBird\Objects\Arrayable;
use MessageBird\Objects\Conversation\Conversation;
use MessageBird\Resources\Base;

/**
 *
 */
class Conversations extends Base
{
    /**
     * @param ClientInterface $httpClient
     * @param JsonMapper $jsonMapper
     */
    public function __construct(ClientInterface $httpClient, JsonMapper $jsonMapper)
    {
        parent::__construct($httpClient, $jsonMapper,'conversations');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Conversation::class;
    }

    /**
     * Starts a conversation by sending an initial message.
     *
     * @param Arrayable $params
     * @param array $query
     * @return \MessageBird\Objects\Base|Conversation
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function start(Arrayable $params, array $query = []): Conversation
    {
        $uri = $this->getResourceName() . '/start';

        if (empty($query) === false) {
            $uri .= '?' . http_build_query($query);
        }

        $response = $this->httpClient->request(HttpClient::REQUEST_POST, $uri, [
            'body' => $params->toArray()
        ]);

        return $this->handleCreateResponse($response);
    }

    /**
     * @param string $id
     * @param Arrayable $params
     * @return \MessageBird\Objects\Base|Conversation
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function update(string $id, Arrayable $params): Conversation
    {
        $response = $this->httpClient->request(
            $this->getResourceName() . '/' . $id,
            HttpClient::REQUEST_PATCH,
            ['body' => $params->toArray()]
        );

        return $this->handleCreateResponse($response);
    }
}
