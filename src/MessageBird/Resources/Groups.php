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
     * @var Contacts
     */
    private $contactsObject;

    public function __construct(Common\HttpClient $httpClient)
    {
        $this->object = new Objects\Group();
        $this->setResourceName('groups');

        $this->contactsObject = new Contacts($httpClient);

        parent::__construct($httpClient);
    }

    /**
     * @param mixed $object
     * @param mixed $id
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|null ->object
     *
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     * @throws \JsonException
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

        [, , $body] = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_PATCH,
            $resourceName,
            false,
            $body
        );
        return $this->processRequest($body);
    }

    /**
     * @param string|null $id
     * @param array|null $parameters
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     * @throws \JsonException
     *
     */
    public function getContacts(?string $id = null, ?array $parameters = [])
    {
        if ($id === null) {
            throw new InvalidArgumentException('No group id provided.');
        }

        $this->contactsObject->setResourceName($this->resourceName . '/' . $id . '/contacts');
        return $this->contactsObject->getList($parameters);
    }

    /**
     * @param array $contacts
     * @param string|null $id
     *
     * @return mixed
     * @throws Exceptions\HttpException
     * @throws InvalidArgumentException
     *
     * @throws Exceptions\AuthenticateException
     * @throws \JsonException
     */
    public function addContacts(array $contacts, ?string $id = null)
    {
        if (!\is_array($contacts)) {
            throw new  InvalidArgumentException('No array with contacts provided.');
        }
        if ($id === null) {
            throw new InvalidArgumentException('No group id provided.');
        }

        $resourceName = $this->resourceName . ($id ? '/' . $id . '/contacts' : null);
        $contacts = json_encode($contacts, \JSON_THROW_ON_ERROR);
        [$responseStatus, , $responseBody] = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_PUT,
            $resourceName,
            false,
            $contacts
        );
        if ($responseStatus !== Common\HttpClient::HTTP_NO_CONTENT) {
            return json_decode($responseBody, null, 512, \JSON_THROW_ON_ERROR);
        }
    }

    /**
     * @param string|null $contact_id
     * @param string|null $id
     *
     * @return mixed
     * @throws Exceptions\HttpException
     *
     * @throws Exceptions\AuthenticateException
     * @throws \JsonException
     */
    public function removeContact(?string $contact_id = null, ?string $id = null)
    {
        if ($contact_id === null || $id === null) {
            throw new InvalidArgumentException('Null Contact or Group id.');
        }
        $resourceName = $this->resourceName . ($id ? '/' . $id . '/contacts/' . $contact_id : null);

        [$responseStatus, , $responseBody] = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_DELETE,
            $resourceName
        );
        if ($responseStatus !== Common\HttpClient::HTTP_NO_CONTENT) {
            return json_decode($responseBody, null, 512, \JSON_THROW_ON_ERROR);
        }
    }
}
