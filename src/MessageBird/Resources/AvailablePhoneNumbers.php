<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;

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
    protected $HttpClient;

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->HttpClient = $HttpClient;
    }

    /**
     * @param string $countryCode
     * @param array $parameters
     *
     * @return Objects\BaseList
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function getList($countryCode, $parameters = []): Objects\BaseList
    {
        list($status, , $body) = $this->HttpClient->performHttpRequest(
            Common\HttpClient::REQUEST_GET,
            "available-phone-numbers/$countryCode",
            $parameters
        );

        if ($status !== 200) {
            return $this->processRequest($body);
        }
        $body = json_decode($body);

        $items = $body->data;
        unset($body->data);

        $baseList = new Objects\BaseList();
        $baseList->loadFromArray($body);

        foreach ($items as $item) {
            $object = new Objects\Number($this->HttpClient);

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
            $ResponseError = new Common\ResponseError($body);
            throw new \MessageBird\Exceptions\RequestException($ResponseError->getErrorString());
        }

        return Objects\Number.loadFromArray($body->data[0]);
    }
}
?>
