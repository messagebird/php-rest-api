<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;

/**
 * Class Verify
 *
 * @package MessageBird\Resources
 */
class Lookup extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->setObject(new Objects\Lookup);
        $this->setResourceName('lookup');

        parent::__construct($HttpClient);
    }

    /**
     * @param $phoneNumber
     *
     * @return $this->Object
     *
     * @throws \MessageBird\Exceptions\HttpException
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function read($phoneNumber = null)
    {
        $ResourceName = $this->resourceName . '/' . $phoneNumber;
        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $ResourceName);
        return $this->processRequest($body);
    }

    private function hlr($phoneNumber, $method)
    {
        $ResourceName = $this->resourceName . '/' . $phoneNumber . '/hlr' ;
        list(, , $body) = $this->HttpClient->performHttpRequest($method, $ResourceName);
        return $this->processRequest($body);
    }

    /**
     * @param $phoneNumber
     *
     * @return $this->Object
     *
     * @throws \MessageBird\Exceptions\HttpException
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function readHLR($phoneNumber)
    {
        return $this->hlr($phoneNumber, Common\HttpClient::REQUEST_GET);
    }

    /**
     * @param $phoneNumber
     *
     * @return $this->Object
     *
     * @throws \MessageBird\Exceptions\HttpException
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function requestHLR($phoneNumber)
    {
        return $this->hlr($phoneNumber, Common\HttpClient::REQUEST_POST);
    }

}
