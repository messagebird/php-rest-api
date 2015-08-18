<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;

/**
 * Class Verify
 *
 * @package MessageBird\Resources
 */
class Verify extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->setObject(new Objects\Verify);
        $this->setResourceName('verify');

        parent::__construct($HttpClient);
    }

    /**
     * @param $id
     * @param $token
     *
     * @return $this->Object
     *
     * @throws \MessageBird\Exceptions\HttpException
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function verify($id, $token)
    {
        $ResourceName = $this->resourceName . (($id) ? '/' . $id : null);
        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $ResourceName, array('token' => $token));
        return $this->processRequest($body);
    }
}
