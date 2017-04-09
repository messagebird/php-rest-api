<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;
use MessageBird\HttpClient;
use MessageBird\Exceptions;

/**
 * Class Groups
 *
 * @package MessageBird\Resources
 */
class Groups extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->setObject(new Objects\Group());
        $this->setResourceName('groups');

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
     * @param string $id
     * @return $this
     */
    public function getContacts($id = null)
    {
        if (is_null($id)) {
            throw new InvalidArgumentException('No group id provided.');
        }

        $ResourceName = $this->resourceName . '/' . $id . '/contacts';
        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $ResourceName);

        return $this->processRequest($body);
    }

    /**
     * @param array $contacts
     * @param string $id
     */
    public function addContacts($contacts, $id)
    {
        if (!is_array($contacts)) {
            throw new  InvalidArgumentException('No array with contacts provided.');
        }

        $ResourceName = $this->resourceName . ($id ? '/' . $id . '/contacts' : null);
        $contacts = json_encode($contacts);
        list($responceStatus, $responseHeader, $responseBody) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_PUT,
            $ResourceName, false,
            $contacts);
        if (!$responceStatus === 204) {
            $this->Object->loadFromArray($responseBody);
        }
    }
}
