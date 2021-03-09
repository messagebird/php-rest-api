<?php

namespace MessageBird\Resources;

use InvalidArgumentException;
use MessageBird\Common;
use MessageBird\Objects;

/**
 * Class Contacts
 *
 * @package MessageBird\Resources
 */
class Contacts extends Base
{

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->setObject(new Objects\Contact());
        $this->setResourceName('contacts');

        parent::__construct($httpClient);
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

        list(, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_PATCH, $resourceName, false,
            $body);
        return $this->processRequest($body);
    }

    /**
     * @param mixed $id
     * @param array|null $parameters
     * @return $this ->object
     */
    public function getMessages($id, $parameters = [])
    {
        if ($id === null) {
            throw new InvalidArgumentException('No contact id provided.');
        }

        $this->setObject(new Objects\Message());
        $this->setResourceName($this->resourceName . '/' . $id . '/messages');
        return $this->getList($parameters);
    }

    /**
     * @param mixed $id
     * @param array|null $parameters
     * @return $this ->object
     */
    public function getGroups($id, $parameters = [])
    {
        if ($id === null) {
            throw new InvalidArgumentException('No contact id provided.');
        }

        $this->setObject(new Objects\Group());
        $this->setResourceName($this->resourceName . '/' . $id . '/groups');
        return $this->getList($parameters);
    }
}
