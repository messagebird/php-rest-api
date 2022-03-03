<?php

namespace MessageBird\Resources\Voice;

use MessageBird\Common;
use MessageBird\Common\HttpClient;
use MessageBird\Exceptions;
use MessageBird\Objects;

/**
 * Class Legs
 *
 * @package MessageBird\Resources\Voice
 */
class Legs
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    /**
     * @var Objects\Voice\Leg
     */
    protected $object;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
        $this->object = new Objects\Voice\Leg();
    }

    public function getObject(): Objects\Voice\Leg
    {
        return $this->object;
    }

    /**
     * @deprecated
     * 
     * @param mixed $object
     */
    public function setObject($object): void
    {
        $this->object = $object;
    }

    /**
     * @param string $callId
     * @param array $parameters
     *
     * @return Objects\BaseList|Objects\Voice\Leg
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
     * @throws \JsonException
     */
    public function getList(string $callId, array $parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            "calls/$callId/legs",
            $parameters
        );

        if ($status === 200) {
            $body = json_decode($body, null, 512, \JSON_THROW_ON_ERROR);

            $items = $body->data;
            unset($body->data);

            $baseList = new Objects\BaseList();
            $baseList->loadFromStdclass($body);

            $objectName = $this->object;

            foreach ($items as $item) {
                /** @psalm-suppress UndefinedClass */
                $object = new $objectName($this->httpClient);

                $itemObject = $object->loadFromStdclass($item);
                $baseList->items[] = $itemObject;
            }
            return $baseList;
        }

        return $this->processRequest($body);
    }

    /**
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function processRequest(?string $body): Objects\Voice\Leg
    {
        if ($body === null) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        try {
            $body = json_decode($body, null, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        if (empty($body->errors)) {
            return $this->object->loadFromStdclass($body->data[0]);
        }

        $responseError = new Common\ResponseError($body);
        throw new Exceptions\RequestException($responseError->getErrorString());
    }

    public function read(string $callId, string $legId): Objects\Voice\Leg
    {
        [, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            "calls/$callId/legs/$legId"
        );

        return $this->processRequest($body);
    }
}
