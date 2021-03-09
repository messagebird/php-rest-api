<?php

namespace MessageBird\Resources;

use InvalidArgumentException;
use MessageBird\Common;
use MessageBird\Exceptions;
use MessageBird\Objects;

/**
 * Class Groups
 *
 * @package MessageBird\Resources
 */
class Groups extends Base
{

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->setObject(new Objects\Group());
        $this->setResourceName('groups');

        parent::__construct($httpClient);
    }

    /**
     * @param mixed $object
     * @param mixed $id
     *
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
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

        list(, , $body) = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_PATCH,
            $resourceName,
            false,
            $body
        );
        return $this->processRequest($body);
    }

    /**
     * @param string $id
     * @param array|null $parameters
     *
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    public function getContacts($id = null, $parameters = [])
    {
        if ($id === null) {
            throw new InvalidArgumentException('No group id provided.');
        }

        $this->setResourceName($this->resourceName . '/' . $id . '/contacts');
        return $this->getList($parameters);
    }

    /**
     * @param array $contacts
     * @param string $id
     *
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
     * @throws InvalidArgumentException
     *
     * @return mixed
     */
    public function addContacts($contacts, $id = null)
    {
        if (!is_array($contacts)) {
            throw new  InvalidArgumentException('No array with contacts provided.');
        }
        if ($id === null) {
            throw new InvalidArgumentException('No group id provided.');
        }

        $resourceName = $this->resourceName . ($id ? '/' . $id . '/contacts' : null);
        $contacts = json_encode($contacts);
        list($responseStatus, , $responseBody) = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_PUT,
            $resourceName,
            false,
            $contacts
        );
        if ($responseStatus !== Common\HttpClient::HTTP_NO_CONTENT) {
            return json_decode($responseBody);
        }
    }

    /**
     * @param string $contact_id
     * @param string $id
     *
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
     * @throws InvalidArgumentException;
     *
     * @return mixed
     */
    public function removeContact($contact_id = null, $id = null)
    {
        if ($contact_id === null || $id === null) {
            throw new InvalidArgumentException('Null Contact or Group id.');
        }
        $resourceName = $this->resourceName . ($id ? '/' . $id . '/contacts/' . $contact_id : null);

        list($responseStatus, , $responseBody) = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_DELETE,
            $resourceName
        );
        if ($responseStatus !== Common\HttpClient::HTTP_NO_CONTENT) {
            return json_decode($responseBody);
        }
    }
}
