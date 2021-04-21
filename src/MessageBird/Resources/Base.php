<?php

namespace MessageBird\Resources;

use MessageBird\Common;
use MessageBird\Exceptions;
use MessageBird\Objects;

/**
 * Class Base
 *
 * @package MessageBird\Resources
 */
class Base
{
    /**
     * @var \MessageBird\Common\HttpClient
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

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param mixed $resourceName
     *
     * @return void
     */
    public function setResourceName($resourceName): void
    {
        $this->resourceName = $resourceName;
    }

    /**
     * @return string
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * @param mixed $object
     *
     * @return void
     */
    public function setObject($object): void
    {
        $this->object = $object;
    }

    /**
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param mixed $responseObject
     *
     * @return void
     */
    public function setResponseObject($responseObject): void
    {
        $this->responseObject = $responseObject;
    }

    /**
     * @return Objects\MessageResponse
     */
    public function getResponseObject()
    {
        return $this->responseObject;
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
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function create($object, $query = null)
    {
        $body = json_encode($object);
        list(, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_POST, $this->resourceName, $query, $body);
        return $this->processRequest($body);
    }

    /**
     * @param array|null $parameters
     *
     * @return Objects\Balance|Objects\BaseList|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|null
     */
    public function getList(?array $parameters =  [])
    {
        list($status, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $this->resourceName, $parameters);

        if ($status === 200) {
            $body = json_decode($body);

            $items = $body->items;
            unset($body->items);

            $baseList = new Objects\BaseList();
            $baseList->loadFromArray($body);

            $objectName = $this->object;

            foreach ($items as $item) {
                /** @psalm-suppress UndefinedClass */
                $object = new $objectName($this->httpClient);

                $message           = $object->loadFromArray($item);
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
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function read($id = null)
    {
        $resourceName = $this->resourceName . (($id) ? '/' . $id : null);
        list(, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $resourceName);
        return $this->processRequest($body);
    }

    /**
     * @param mixed $id
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|null|true
     *
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function delete($id)
    {
        $resourceName = $this->resourceName . '/' . $id;
        list($status, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_DELETE, $resourceName);

        if ($status === Common\HttpClient::HTTP_NO_CONTENT) {
            return true;
        }

        return $this->processRequest($body);
    }

    /**
     * @param string $body
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|Objects\MessageResponse|null
     *
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function processRequest($body)
    {
        $body = @json_decode($body);

        if ($body === null || $body === false) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        if (!empty($body->errors)) {
            $responseError = new Common\ResponseError($body);
            throw new Exceptions\RequestException($responseError->getErrorString());
        }

        if ($this->responseObject) {
            return $this->responseObject->loadFromArray($body);
        }

        return $this->object->loadFromArray($body);
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
        $body = json_encode($body);

        list(, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_PUT, $resourceName, false, $body);
        return $this->processRequest($body);
    }

    /**
     * @return Common\HttpClient
     */
    public function getHttpClient(): Common\HttpClient
    {
        return $this->httpClient;
    }
}
