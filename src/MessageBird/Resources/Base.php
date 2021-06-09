<?php

namespace MessageBird\Resources;

use MessageBird\Common;
use MessageBird\Common\HttpClient;
use MessageBird\Exceptions;
use MessageBird\Exceptions\RequestException;
use MessageBird\Exceptions\ServerException;
use MessageBird\Objects;

/**
 * Class Base
 *
 * @package MessageBird\Resources
 */
class Base
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var string The resource name as it is known at the server
     */
    protected $resourceName;

    /**
     * @var Objects\Hlr|Objects\Message|Objects\Balance|Objects\Verify|Objects\Lookup|Objects\VoiceMessage|Objects\Conversation\Conversation
     */
    protected $object;

    /**
     * @var Objects\MessageResponse
     */
    protected $responseObject;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return string
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * @param mixed $resourceName
     */
    public function setResourceName($resourceName): void
    {
        $this->resourceName = $resourceName;
    }

    /**
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param mixed $object
     */
    public function setObject($object): void
    {
        $this->object = $object;
    }

    /**
     * @return Objects\MessageResponse
     */
    public function getResponseObject()
    {
        return $this->responseObject;
    }

    /**
     * @param mixed $responseObject
     */
    public function setResponseObject($responseObject): void
    {
        $this->responseObject = $responseObject;
    }

    /**
     * @no-named-arguments
     *
     * @param mixed $object
     * @param array|null $query
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\MessageResponse|Objects\Verify|Objects\VoiceMessage|null
     *
     * @throws Exceptions\HttpException
     * @throws RequestException
     * @throws ServerException
     */
    public function create($object, $query = null)
    {
        $body = json_encode($object, JSON_THROW_ON_ERROR);
        [, , $body] = $this->httpClient->performHttpRequest(HttpClient::REQUEST_POST, $this->resourceName,
            $query, $body);
        return $this->processRequest($body);
    }

    /**
     * @param string $body
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|Objects\MessageResponse|null
     *
     * @throws RequestException
     * @throws ServerException
     */
    public function processRequest($body)
    {
        $body = @json_decode($body, null, 512, JSON_THROW_ON_ERROR);

        if ($body === null || $body === false) {
            throw new ServerException('Got an invalid JSON response from the server.');
        }

        if (!empty($body->errors)) {
            $responseError = new Common\ResponseError($body);
            throw new RequestException($responseError->getErrorString());
        }

        if ($this->responseObject) {
            return $this->responseObject->loadFromArray($body);
        }

        return $this->object->loadFromArray($body);
    }

    /**
     * @return Objects\Balance|Objects\BaseList|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|null
     */
    public function getList(?array $parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(HttpClient::REQUEST_GET, $this->resourceName,
            $parameters);

        if ($status === 200) {
            $body = json_decode($body, null, 512, JSON_THROW_ON_ERROR);

            $items = $body->items;
            unset($body->items);

            $baseList = new Objects\BaseList();
            $baseList->loadFromArray($body);

            $objectName = $this->object;

            foreach ($items as $item) {
                /** @psalm-suppress UndefinedClass */
                $object = new $objectName($this->httpClient);

                $message = $object->loadFromArray($item);
                $baseList->items[] = $message;
            }
            return $baseList;
        }

        return $this->processRequest($body);
    }

    /**
     * @no-named-arguments
     *
     * @param mixed $id
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|null
     *
     * @throws RequestException
     * @throws ServerException
     */
    public function read($id = null)
    {
        $resourceName = $this->resourceName . (($id) ? '/' . $id : null);
        [, , $body] = $this->httpClient->performHttpRequest(HttpClient::REQUEST_GET, $resourceName);
        return $this->processRequest($body);
    }

    /**
     * @param mixed $id
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|null|true
     *
     * @throws RequestException
     * @throws ServerException
     */
    public function delete($id)
    {
        $resourceName = $this->resourceName . '/' . $id;
        [$status, , $body] = $this->httpClient->performHttpRequest(HttpClient::REQUEST_DELETE, $resourceName);

        if ($status === HttpClient::HTTP_NO_CONTENT) {
            return true;
        }

        return $this->processRequest($body);
    }

    /**
     * @param mixed $object
     * @param mixed $id
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|null ->object
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
        $body = json_encode($body, JSON_THROW_ON_ERROR);

        [, , $body] = $this->httpClient->performHttpRequest(HttpClient::REQUEST_PUT, $resourceName, false,
            $body);
        return $this->processRequest($body);
    }

    public function getHttpClient(): HttpClient
    {
        return $this->httpClient;
    }
}
