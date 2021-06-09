<?php

namespace MessageBird\Resources\Conversation;

use MessageBird\Common\HttpClient;
use MessageBird\Common\ResponseError;
use MessageBird\Exceptions\HttpException;
use MessageBird\Exceptions\RequestException;
use MessageBird\Exceptions\ServerException;
use MessageBird\Objects\BaseList;
use MessageBird\Objects\Conversation\Message;

/**
 * Messages does not extend Base because PHP won't let us add parameters to the
 * create and getList functions in overrides.
 */
class Messages
{
    public const HTTP_STATUS_OK = 200;

    public const RESOURCE_NAME = 'conversations/%s/messages';
    public const MESSAGE_RESOURCE_NAME = 'messages/%s';

    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var Message
     */
    protected $object;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;

        $this->setObject(new Message());
    }

    /**
     * @return Message
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param Message $object
     */
    public function setObject($object): void
    {
        $this->object = $object;
    }

    /**
     * Send a message to a conversation.
     *
     * @param string $conversationId
     * @param Message $object
     * @param string[]|null $query
     *
     *
     * @throws HttpException
     * @throws RequestException
     * @throws ServerException
     */
    public function create($conversationId, $object, $query = null): Message
    {
        $body = json_encode($object, JSON_THROW_ON_ERROR);

        [, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_POST,
            $this->getResourceNameWithId($conversationId),
            $query,
            $body
        );

        return $this->processRequest($body);
    }

    /**
     * Formats a URL for the Conversation API's messages endpoint based on the
     * conversationId.
     *
     * @param string $id
     *
     * @return string
     */
    private function getResourceNameWithId($id)
    {
        return sprintf(self::RESOURCE_NAME, $id);
    }

    /**
     * Throws an exception if the request if the request has any errors.
     *
     * @param string $body
     *
     *
     * @throws RequestException
     * @throws ServerException
     */
    public function processRequest($body): Message
    {
        $body = @json_decode($body, null, 512, JSON_THROW_ON_ERROR);

        if ($body === null || $body === false) {
            throw new ServerException('Got an invalid JSON response from the server.');
        }

        if (empty($body->errors)) {
            return $this->object->loadFromArray($body);
        }

        $responseError = new ResponseError($body);

        throw new RequestException(
            $responseError->getErrorString()
        );
    }

    /**
     * Retrieves all the messages form the conversation based on its
     * conversationId.
     *
     * @param string $conversationId
     * @param string[] $parameters
     *
     * @return BaseList|Message
     */
    public function getList($conversationId, $parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            $this->getResourceNameWithId($conversationId),
            $parameters
        );

        if ($status === self::HTTP_STATUS_OK) {
            $body = json_decode($body, null, 512, JSON_THROW_ON_ERROR);

            $items = $body->items;
            unset($body->items);

            $baseList = new BaseList();
            $baseList->loadFromArray($body);

            $objectName = $this->object;

            foreach ($items as $item) {
                /** @psalm-suppress UndefinedClass */
                $message = new $objectName($this->httpClient);
                $message->loadFromArray($item);

                $baseList->items[] = $message;
            }

            return $baseList;
        }

        return $this->processRequest($body);
    }

    /**
     * @return Message|self
     */
    public function read($messageId, $parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            sprintf(self::MESSAGE_RESOURCE_NAME, $messageId),
            $parameters
        );

        if ($status !== self::HTTP_STATUS_OK) {
            return $this->processRequest($body);
        }

        $body = json_decode($body, null, 512, JSON_THROW_ON_ERROR);
        if (empty($body)) {
            return $this->processRequest($body);
        }

        $message = new Message();
        $message->loadFromArray($body);

        return $message;
    }
}
