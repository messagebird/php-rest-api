<?php

namespace MessageBird\Resources\Conversation;

use MessageBird\Common\HttpClient;
use MessageBird\Exceptions;
use MessageBird\Objects\Balance;
use MessageBird\Objects\Conversation\Conversation;
use MessageBird\Objects\Conversation\Message;
use MessageBird\Objects\Hlr;
use MessageBird\Objects\Lookup;
use MessageBird\Objects\Verify;
use MessageBird\Objects\VoiceMessage;
use MessageBird\Resources\Base;

class Conversations extends Base
{
    public const RESOURCE_NAME = 'conversations';

    public function __construct(HttpClient $httpClient)
    {
        parent::__construct($httpClient);

        $this->object = new Conversation();
        $this->setResourceName(self::RESOURCE_NAME);
    }

    /**
     * Starts a conversation by sending an initial message.
     *
     * @param Message $object
     * @param array|null $query
     *
     * @return Conversation|Balance|Hlr|Lookup|\MessageBird\Objects\Message|Verify|VoiceMessage|null
     *
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function start($object, $query = null)
    {
        $body = json_encode($object, \JSON_THROW_ON_ERROR);

        [, , $body] = $this->httpClient->performHttpRequest(
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
    private function getStartUrl(): string
    {
        return $this->resourceName . '/start';
    }

    /**
     * Starts a conversation without sending an initial message.
     *
     * @param int $object
     *
     * @return Conversation|Balance|Hlr|Lookup|\MessageBird\Objects\Message|Verify|VoiceMessage|null
     *
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function create($object, array $query = null)
    {
        $body = json_encode(['contactId' => $object], \JSON_THROW_ON_ERROR);

        [, , $body] = $this->httpClient->performHttpRequest(
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
     * @return Conversation|Balance|Hlr|Lookup|\MessageBird\Objects\Message|Verify|VoiceMessage|null ->object
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
        $body = json_encode($body, \JSON_THROW_ON_ERROR);

        [, , $body] = $this->httpClient->performHttpRequest(HttpClient::REQUEST_PATCH, $resourceName, false, $body);

        return $this->processRequest($body);
    }
}
