<?php

namespace MessageBird\Resources\Conversation;

use GuzzleHttp\ClientInterface;
use MessageBird\Common\HttpClient;
use MessageBird\Objects\Arrayable;
use MessageBird\Objects\BaseList;
use MessageBird\Objects\Conversation\Message;
use MessageBird\Resources\Base;

/**
 * Messages does not extend Base because PHP won't let us add parameters to the
 * create and getList functions in overrides.
 */
class Messages extends Base
{
    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        parent::__construct($httpClient, 'conversations');
    }

    /**
     * @return string
     */
    protected function responseClass(): string
    {
        return Message::class;
    }

    /**
     * Send a message to a conversation.
     *
     * @param string $conversationId
     * @param Arrayable $message
     * @param array $query
     * @return Message|\MessageBird\Objects\Base
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonMapper_Exception
     */
    public function create(string $conversationId, Arrayable $message, array $query = []): Message
    {
        $uri = "{$this->getResourceName()}/$conversationId/messages";

        if (empty($query)) {
            $uri .= '?' . http_build_query($query);
        }

        $response = $this->httpClient->request(HttpClient::REQUEST_POST, $uri, [
            'body' => $message->toArray()
        ]);

        return $this->handleCreateResponse($response);
    }

    /**
     * Retrieves all the messages form the conversation based on its conversationId.
     *
     * @param string $conversationId
     * @param array $params
     * @return BaseList
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function list(string $conversationId, array $params = []): BaseList
    {
        $uri = "{$this->getResourceName()}/$conversationId/messages";

        if (empty($params) === false) {
            $uri .= '?' . http_build_query($params);
        }

        $response = $this->httpClient->request(HttpClient::REQUEST_GET, $uri);

        return $this->handleListResponse($response);
    }
}
