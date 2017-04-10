<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;
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
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
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

        list(, , $body) = $this->HttpClient->performHttpRequest(
            Common\HttpClient::REQUEST_PATCH,
            $ResourceName,
            false,
            $body
        );
        return $this->processRequest($body);
    }

    /**
     * @param string $id
     *
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
     *
     * @return mixed
     */
    public function getContacts($id = null)
    {
        if (is_null($id)) {
            throw new InvalidArgumentException('No group id provided.');
        }

        $ResourceName = $this->resourceName . '/' . $id . '/contacts';
        list(, , $body) = $this->HttpClient->performHttpRequest(
            Common\HttpClient::REQUEST_GET,
            $ResourceName
        );

        return $this->processRequest($body);
    }

    /**
     * @param array $contacts
     * @param string $id
     *
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
     *
     * @return mixed
     */
    public function addContacts($contacts, $id)
    {
        if (!is_array($contacts)) {
            throw new  InvalidArgumentException('No array with contacts provided.');
        }

        $ResourceName = $this->resourceName . ($id ? '/' . $id . '/contacts' : null);
        $contacts = json_encode($contacts);
        list($responceStatus, , $responseBody) = $this->HttpClient->performHttpRequest(
            Common\HttpClient::REQUEST_PUT,
            $ResourceName,
            false,
            $contacts
        );
        if ($responceStatus !== Common\HttpClient::HTTP_NO_CONTENT) {
            return json_decode($responseBody);
        }
    }

    /**
     * @param string $contact_id
     * @param string $id
     *
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
     *
     * @return mixed
     */
    public function removeContact($contact_id, $id)
    {
        if (is_null($contact_id) || is_null($id))
        {
            throw new InvalidArgumentException('Null Contact or Group id.');
        }
        $ResourceName = $this->resourceName . ($id ? '/' . $id . '/contacts/' . $contact_id : null);

        list($responceStatus, , $responseBody) = $this->HttpClient->performHttpRequest(
            Common\HttpClient::REQUEST_DELETE,
            $ResourceName
        );
        if ($responceStatus !== Common\HttpClient::HTTP_NO_CONTENT) {
            return json_decode($responseBody);
        }
    }
}
