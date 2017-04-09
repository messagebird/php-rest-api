<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Exceptions;
use MessageBird\Common;

/**
 * Class Contacts
 *
 * @package MessageBird\Resources
 */
class Contacts extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->setObject(new Objects\Contact());
        $this->setResourceName('contacts');

        parent::__construct($HttpClient);
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

        $ResourceName = $this->resourceName . ($id ? '/' . $id : null);
        $body = json_encode($body);

        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_PATCH, $ResourceName, false,
            $body);
        return $this->processRequest($body);
    }

    /**
     * @param $id
     * @return $this ->Object
     */
    public function getMessages($id)
    {
        if (is_null($id)) {
            throw new InvalidArgumentException('No contact id provided.');
        }

        $ResourceName = $this->resourceName . '/' . $id . '/messages';
        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $ResourceName);

        return $this->processMessageRequest($body);
    }

    /**
     * @param $id
     * @return $this ->Object
     */
    public function getGroups($id)
    {
        if (is_null($id)) {
            throw new InvalidArgumentException('No contact id provided.');
        }

        $ResourceName = $this->resourceName . '/' . $id . '/groups';
        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $ResourceName);

        return $this->processGroupRequest($body);
    }

    /**
     * @param string $body
     *
     * @return $this
     *
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function processMessageRequest($body)
    {
        $body = @json_decode($body);

        if ($body === null or $body === false) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        if (empty($body->errors)) {
            return $this->Object->loadFromArray($body);
        }

        $ResponseError = new Common\ResponseError($body);
        throw new Exceptions\RequestException($ResponseError->getErrorString());
    }

    /**
     * @param string $body
     *
     * @return $this
     *
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function processGroupRequest($body)
    {
        $body = @json_decode($body);

        if ($body === null or $body === false) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        if (empty($body->errors)) {
            return $this->Object->loadFromArrayForGroups($body);
        }

        $ResponseError = new Common\ResponseError($body);
        throw new Exceptions\RequestException($ResponseError->getErrorString());
    }
}
