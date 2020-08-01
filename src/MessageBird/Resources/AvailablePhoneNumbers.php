<?php

namespace MessageBird\Resources;

use MessageBird\Common;
use MessageBird\Objects;

/**
 * Class AvailablePhoneNumbers
 *
 * @package MessageBird\Resources
 */
class AvailablePhoneNumbers
{

    /**
     * @var \MessageBird\Common\HttpClient
     */
    protected $httpClient;

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     * @param string $countryCode
     * @param array $parameters
     *
     * @return Objects\BaseList|Objects\Number
     *
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function getList($countryCode, $parameters = [])
    {
        list($status, , $body) = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_GET,
            "available-phone-numbers/$countryCode",
            $parameters
        );

        if ($status !== 200) {
            return $this->processRequest($body);
        }
        $body = json_decode($body);

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
     * @return Objects\Number
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    private function processRequest($body): Objects\Number
    {
        $body = json_decode($body);

        if (json_last_error()) {
            throw new \MessageBird\Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        if (!empty($body->errors)) {
            $responseError = new Common\ResponseError($body);
            throw new \MessageBird\Exceptions\RequestException($responseError->getErrorString());
        }

        return (new Objects\Number())->loadFromArray($body->data[0]);
    }
}
