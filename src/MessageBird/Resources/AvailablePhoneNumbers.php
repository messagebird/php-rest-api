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
    public function getList($countryCode, $parameters = array())
    {
        list($status, , $body) = $this->HttpClient->performHttpRequest(
            Common\HttpClient::REQUEST_GET,
            "available-phone-numbers/$countryCode",
            $parameters
        );

        if ($status === 200) {
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

        return $this->processRequest($body);
    }

    /**
     * @param string $body
     *
     * @return Objects\Number
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    private function processRequest($body)
    {
        $body = @json_decode($body);

        if ($body === null or $body === false) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        if (empty($body->errors)) {
            return Objects\Number.loadFromArray($body->data[0]);
        }

        $ResponseError = new Common\ResponseError($body);
        throw new Exceptions\RequestException($ResponseError->getErrorString());
    }
}
?>
