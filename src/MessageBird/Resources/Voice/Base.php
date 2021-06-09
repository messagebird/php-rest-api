<?php

namespace MessageBird\Resources\Voice;

use MessageBird\Common;
use MessageBird\Exceptions;
use MessageBird\Objects\Balance;
use MessageBird\Objects\Conversation\Conversation;
use MessageBird\Objects\Hlr;
use MessageBird\Objects\Lookup;
use MessageBird\Objects\Message;
use MessageBird\Objects\Verify;
use MessageBird\Objects\Voice\BaseList;
use MessageBird\Objects\VoiceMessage;

/**
 * Class Base
 *
 * @package MessageBird\Resources\Voice
 */
class Base extends \MessageBird\Resources\Base
{
    /**
     * @return BaseList|Balance|Conversation|Hlr|Lookup|Message|Verify|VoiceMessage|null
     */
    public function getList($parameters = [])
    {
        [$status, , $body] = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_GET,
            $this->resourceName,
            $parameters
        );

        if ($status === 200) {
            $body = json_decode($body, null, 512, JSON_THROW_ON_ERROR);

            $data = $body->data;

            $baseList = new BaseList();
            if (property_exists($body, 'pagination')) {
                $baseList->loadFromArray($body->pagination);
            }

            $objectName = $this->object;

            foreach ($data as $singleData) {
                /** @psalm-suppress UndefinedClass */
                $itemObject = new $objectName($this->httpClient);

                $message = $itemObject->loadFromArray($singleData);
                $baseList->items[] = $message;
            }
            return $baseList;
        }

        return $this->processRequest($body);
    }

    /**
     * @inheritdoc
     *
     * @return Balance|Conversation|Hlr|Lookup|Message|Verify|VoiceMessage|null
     */
    public function processRequest($body)
    {
        $body = @json_decode($body, null, 512, JSON_THROW_ON_ERROR);

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
