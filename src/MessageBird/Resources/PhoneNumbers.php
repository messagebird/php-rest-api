<?php

namespace MessageBird\Resources;

use MessageBird\Common\HttpClient;
use MessageBird\Objects;

/**
 * Class PhoneNumbers
 *
 * @package MessageBird\Resources
 */
class PhoneNumbers extends Base
{
    /**
     * @var HttpClient
     */
    protected $httpClient;

    public function __construct(HttpClient $httpClient)
    {
        $this->object = new Objects\Number();
        $this->setResourceName('phone-numbers');

        parent::__construct($httpClient);
    }

    /**
     * @param mixed $object
     * @param mixed $id
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|null
     *
     * @throws \JsonException
     * @throws \MessageBird\Exceptions\AuthenticateException
     * @throws \MessageBird\Exceptions\HttpException
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
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

        // This override is only needed to use the PATCH http method
        [, , $body] = $this->httpClient->performHttpRequest(
            HttpClient::REQUEST_PATCH,
            $resourceName,
            false,
            $body
        );
        return $this->processRequest($body);
    }
}
