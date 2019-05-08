<?php

namespace MessageBird\Resources\Conversation;

use MessageBird\Common\HttpClient;
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
     * @return Message
     * 
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function start($object, $query = null)
    {
        $body = json_encode($object);
        
        list(, , $body) = $this->HttpClient->performHttpRequest(
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
     * @return Message
     * 
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function create($contactId, $query = null)
    {
        $body = json_encode(array('contactId' => $contactId));

        list(, , $body) = $this->HttpClient->performHttpRequest(
            HttpClient::REQUEST_POST,
            $this->resourceName,
            $query,
            $body
        );

        return $this->processRequest($body);
    }

    /**
     * @param $object
     * @param $id
     *
     * @return $this ->Object
     *
     * @internal param array $parameters
     */
    public function update($object, $id)
    {
        $objVars = get_object_vars($object);
        $body = array();

        foreach ($objVars as $key => $value) {
            if (null !== $value) {
                $body[$key] = $value;
            }
        }

        $resourceName = $this->resourceName . ($id ? '/' . $id : null);
        $body = json_encode($body);

        list(, , $body) = $this->HttpClient->performHttpRequest(HttpClient::REQUEST_PATCH, $resourceName, false, $body);

        return $this->processRequest($body);
    }
}
