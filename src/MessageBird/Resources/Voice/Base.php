<?php

namespace MessageBird\Resources\Voice;

use MessageBird\Common;
use MessageBird\Exceptions;
use MessageBird\Objects\Voice\BaseList;

/**
 * Class Base
 *
 * @package MessageBird\Resources\Voice
 */
class Base extends \MessageBird\Resources\Base
{
    public function getList($parameters = [])
    {
        list($status, , $body) = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_GET,
            $this->resourceName,
            $parameters
        );

        if ($status === 200) {
            $body = json_decode($body);

            $data = $body->data;

            $baseList = new BaseList();
            if (property_exists($body, 'pagination')) {
                $baseList->loadFromArray($body->pagination);
            }

            $objectName = $this->object;

            foreach ($data as $item) {
                $itemObject = new $objectName($this->httpClient);

                $message = $itemObject->loadFromArray($item);
                $baseList->items[] = $message;
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

        if ($body === null || $body === false) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        if (empty($body->errors)) {
            return $this->object->loadFromArray($body->data[0]);
        }

        $responseError = new Common\ResponseError($body);
        throw new Exceptions\RequestException($responseError->getErrorString());
    }
}
