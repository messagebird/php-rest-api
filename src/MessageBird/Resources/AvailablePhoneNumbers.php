<?php

namespace MessageBird\Resources;

use MessageBird\Common;
use MessageBird\Common\HttpClient;
use MessageBird\Exceptions;
use MessageBird\Objects;

/**
 * Class AvailablePhoneNumbers
 *
 * @package MessageBird\Resources
 */
class AvailablePhoneNumbers
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @return Objects\BaseList|Objects\Number
     *
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     * @throws \JsonException
     */
    public function getList(string $countryCode, array $parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            "available-phone-numbers/$countryCode",
            $parameters
        );

        if ($status !== 200) {
            return $this->processRequest($body);
        }
        $body = json_decode($body, null, 512, \JSON_THROW_ON_ERROR);

        $items = $body->items;
        unset($body->items);

        $baseList = new Objects\BaseList();
        $baseList->loadFromStdclass($body);

        foreach ($items as $item) {
            $object = new Objects\Number();
            $itemObject = $object->loadFromStdclass($item);
            $baseList->items[] = $itemObject;
        }
        return $baseList;
    }

    /**
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     * @throws Exceptions\ServerException
     * @throws Exceptions\RequestException
     */
    private function processRequest(?string $body): Objects\Number
    {
        if ($body === null) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        try {
            $body = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        if (!empty($body->errors)) {
            $responseError = new Common\ResponseError($body);
            throw new Exceptions\RequestException($responseError->getErrorString());
        }

        return (new Objects\Number())->loadFromStdclass($body->data[0]);
    }
}
