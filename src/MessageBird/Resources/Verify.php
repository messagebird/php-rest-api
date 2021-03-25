<?php

namespace MessageBird\Resources;

use MessageBird\Common;
use MessageBird\Objects;

/**
 * Class Verify
 *
 * @package MessageBird\Resources
 */
class Verify extends Base
{

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->setObject(new Objects\Verify);
        $this->setResourceName('verify');

        parent::__construct($httpClient);
    }

    /**
     * @param mixed $id
     * @param mixed $token
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|null
     *
     * @throws \MessageBird\Exceptions\HttpException
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function verify($id, $token)
    {
        $resourceName = $this->resourceName . (($id) ? '/' . $id : null);
        list(, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $resourceName, ['token' => $token]);
        return $this->processRequest($body);
    }
}
