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
     * @var Objects\Hlr|Objects\Message|Objects\Balance|Objects\Verify|Objects\Lookup|Objects\VoiceMessage
     */
    protected $object;

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param mixed $resourceName
     */
    public function setResourceName($resourceName)
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
     */
    public function setObject($object)
    {
        $this->object = $object;
    }

    /**
     * @return Objects\Hlr|Objects\Message|Objects\Balance|Objects\Verify|Objects\Lookup|Objects\VoiceMessage
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @param mixed $object
     * @param array|null $query
     *
     * @return Objects\Hlr|Objects\Message|Objects\Balance|Objects\Verify|Objects\Lookup|Objects\VoiceMessage
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

    public function getList($parameters =  [])
    {
        list($status, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $this->resourceName, $parameters);

        if ($status === 200) {
            $body = json_decode($body);

            $items = $body->items;
            unset($body->items);

            $baseList = new Objects\BaseList();
            $baseList->loadFromArray($body);

            $objectName = $this->object;

            foreach ($items AS $item) {
                $object = new $objectName($this->httpClient);

                $message           = $object->loadFromArray($item);
                $baseList->items[] = $message;
            }
            return $baseList;
        }

        return $this->processRequest($body);
    }

    /**
     * @param mixed $id
     *
     * @return $this->object
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
     * @return bool
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
     * @return $this
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

        if (empty($body->errors)) {
            return $this->object->loadFromArray($body);
        }

        $responseError = new Common\ResponseError($body);
        throw new Exceptions\RequestException($responseError->getErrorString());
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
