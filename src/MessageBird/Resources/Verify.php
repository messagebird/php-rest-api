<?php

namespace MessageBird\Resources;

use MessageBird\Common;
use MessageBird\Exceptions\AuthenticateException;
use MessageBird\Exceptions\HttpException;
use MessageBird\Exceptions\RequestException;
use MessageBird\Exceptions\ServerException;
use MessageBird\Objects;

/**
 * Class Verify
 *
 * @package MessageBird\Resources
 */
class Verify extends Base
{
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->object = new Objects\Verify();
        $this->setResourceName('verify');

        parent::__construct($httpClient);
    }

    /**
     * @param mixed $id
     * @param mixed $token
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|null
     *
     * @throws HttpException
     * @throws RequestException
     * @throws ServerException|AuthenticateException
     */
    public function verify($id, $token)
    {
        $resourceName = $this->resourceName . (($id) ? '/' . $id : null);
        [, , $body] = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_GET,
            $resourceName,
            ['token' => $token]
        );
        return $this->processRequest($body);
    }
}
