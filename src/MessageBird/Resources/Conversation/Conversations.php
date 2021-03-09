<?php

namespace MessageBird\Resources\Conversation;

use MessageBird\Common\HttpClient;
use MessageBird\Exceptions;
use MessageBird\Objects\Conversation\Conversation;
use MessageBird\Objects\Conversation\Message;
use MessageBird\Resources\Base;

class Conversations extends Base
{
    const RESOURCE_NAME = 'conversations';

    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);

        $this->setObject(new Conversation());
        $this->setResourceName(self::RESOURCE_NAME);
    }

    /**
     * Starts a conversation by sending an initial message.
     *
     * @param Message $object
     * @param array|null $query
     *
     * @return Conversation
     *
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function start($object, $query = null)
    {
        $body = json_encode($object);

        list(, , $body) = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_POST,
            $this->getStartUrl(),
            $query,
            $body
        );

        return $this->processRequest($body);
    }

    /**
     * Conversations API uses a special URL scheme for starting a conversation.
     */
    private function getStartUrl()
    {
        return $this->resourceName . '/start';
    }

    /**
     * Starts a conversation without sending an initial message.
     *
     * @param int $contactId
     *
     * @return Conversation
     *
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function create($contactId, $query = null)
    {
        $body = json_encode(['contactId' => $contactId]);

        list(, , $body) = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_POST,
            $this->resourceName,
            $query,
            $body
        );

        return $this->processRequest($body);
    }

    /**
     * @param mixed $object
     * @param mixed $id
     *
     * @return $this ->object
     *
     * @internal param array $parameters
     */
    public function update($object, $id)
    {
        $objVars = get_object_vars($object);
        $body = [];

        foreach ($objVars as $key => $value) {
            if ($value !== null) {
                $body[$key] = $value;
            }
        }

        $resourceName = $this->resourceName . ($id ? '/' . $id : null);
        $body = json_encode($body);

        list(, , $body) = $this->httpClient->performHttpRequest(HttpClient::REQUEST_PATCH, $resourceName, false, $body);

        return $this->processRequest($body);
    }
}
