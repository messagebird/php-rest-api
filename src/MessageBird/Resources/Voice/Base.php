<?php

namespace MessageBird\Resources\Voice;

use MessageBird\Common;
use MessageBird\Exceptions;
use MessageBird\Objects;

/**
 * Class Base
 *
 * @package MessageBird\Resources\Voice
 */
class Base extends \MessageBird\Resources\Base
{
    public function getList($parameters = array())
    {
        list($status, , $body) = $this->HttpClient->performHttpRequest(
            Common\HttpClient::REQUEST_GET,
            $this->resourceName,
            $parameters
        );

        if ($status === 200) {
            $body = json_decode($body);

            $data = $body->data;
            unset($body->items);

            $baseList = new Objects\BaseList();
            $baseList->loadFromArray($body);

            $objectName = $this->Object;

            foreach ($data as $item) {
                $itemObject = new $objectName($this->HttpClient);

                $Message = $itemObject->loadFromArray($item);
                $baseList->items[] = $Message;
            }
            return $baseList;
        }

        return $this->processRequest($body);
    }

    /**
     * @inheritdoc
     */
    public function processRequest($body)
    {
        $body = @json_decode($body);

        if ($body === null or $body === false) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        if (empty($body->errors)) {
            return $this->Object->loadFromArray($body->data[0]);
        }

        $ResponseError = new Common\ResponseError($body);
        throw new Exceptions\RequestException($ResponseError->getErrorString());
    }
}
