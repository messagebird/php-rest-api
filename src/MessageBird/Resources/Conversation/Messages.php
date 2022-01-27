<?php

namespace MessageBird\Resources\Conversation;

use MessageBird\Common\HttpClient;
use MessageBird\Common\ResponseError;
use MessageBird\Exceptions\AuthenticateException;
use MessageBird\Exceptions\BalanceException;
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

        $this->object = new Message();
    }

    public function getObject(): Message
    {
        return $this->object;
    }

    /**
     * @deprecated
     * 
     * @param Message $object 
     * @return void 
     */
    public function setObject(Message $object): void
    {
        $this->object = $object;
    }

    /**
     * Send a message to a conversation.
     *
     * @throws HttpException
     * @throws RequestException
     * @throws ServerException
     * @throws AuthenticateException
     * @throws \JsonException
     */
    public function create(string $conversationId, Message $object, ?array $query = null): Message
    {
        $body = json_encode($object, \JSON_THROW_ON_ERROR);

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
     */
    private function getResourceNameWithId(string $id): string
    {
        return sprintf(self::RESOURCE_NAME, $id);
    }

    /**
     * Throws an exception if the request if the request has any errors.
     *
     * @throws AuthenticateException
     * @throws RequestException
     * @throws ServerException
     * @throws BalanceException
     * @throws \JsonException
     */
    public function processRequest(string $body): Message
    {
        try {
            $body = json_decode($body, null, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new ServerException('Got an invalid JSON response from the server.');
        }

        if ($body === null) {
            throw new ServerException('Got an invalid JSON response from the server.');
        }

        if (empty($body->errors)) {
            return $this->object->loadFromStdclass($body);
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
     * @return BaseList|Message
     * @throws AuthenticateException
     * @throws BalanceException
     * @throws HttpException
     * @throws RequestException
     * @throws ServerException
     * @throws \JsonException
     */
    public function getList(string $conversationId, array $parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            $this->getResourceNameWithId($conversationId),
            $parameters
        );

        if ($status === self::HTTP_STATUS_OK) {
            try {
                $body = json_decode($body, null, 512, \JSON_THROW_ON_ERROR);
            } catch (\JsonException $e) {
                throw new ServerException('Got an invalid JSON response from the server.');
            }
            $items = $body->items;
            unset($body->items);

            $baseList = new BaseList();
            $baseList->loadFromStdclass($body);

            $objectName = $this->object;

            foreach ($items as $item) {
                /** @psalm-suppress UndefinedClass */
                $message = new $objectName($this->httpClient);
                $message->loadFromStdclass($item);

                $baseList->items[] = $message;
            }

            return $baseList;
        }

        return $this->processRequest($body);
    }

    /**
     * @return Message|self
     * @throws AuthenticateException
     * @throws BalanceException
     * @throws HttpException
     * @throws RequestException
     * @throws ServerException
     * @throws \JsonException
     */
    public function read(string $messageId, ?array $parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            sprintf(self::MESSAGE_RESOURCE_NAME, $messageId),
            $parameters
        );

        if ($status !== self::HTTP_STATUS_OK) {
            return $this->processRequest($body);
        }

        $body = json_decode($body, null, 512, \JSON_THROW_ON_ERROR);
        if (empty($body)) {
            return $this->processRequest($body);
        }

        $message = new Message();
        $message->loadFromStdclass($body);

        return $message;
    }
}
