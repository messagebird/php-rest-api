<?php

namespace MessageBird\Resources;

use MessageBird\Common;
use MessageBird\Common\HttpClient;
use MessageBird\Exceptions\RequestException;
use MessageBird\Exceptions\ServerException;
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
     * @param string $countryCode
     * @param array $parameters
     *
     * @return Objects\BaseList|Objects\Number
     *
     * @throws RequestException
     * @throws ServerException
     */
    public function getList($countryCode, $parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_GET,
            "available-phone-numbers/$countryCode",
            $parameters
        );

        if ($status !== 200) {
            return $this->processRequest($body);
        }
        $body = json_decode($body, null, 512, JSON_THROW_ON_ERROR);

        $items = $body->items;
        unset($body->items);

        $baseList = new Objects\BaseList();
        $baseList->loadFromArray($body);

        foreach ($items as $item) {
            $object = new Objects\Number();
            $itemObject = $object->loadFromArray($item);
            $baseList->items[] = $itemObject;
        }
        return $baseList;
    }

    /**
     * @param string $body
     *
     * @throws RequestException
     * @throws ServerException
     */
    private function processRequest($body): Objects\Number
    {
        $body = json_decode($body);

        if (json_last_error()) {
            throw new ServerException('Got an invalid JSON response from the server.');
        }

        if (!empty($body->errors)) {
            $responseError = new Common\ResponseError($body);
            throw new RequestException($responseError->getErrorString());
        }

        return (new Objects\Number())->loadFromArray($body->data[0]);
    }
}
