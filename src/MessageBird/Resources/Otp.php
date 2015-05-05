<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;

/**
 * Class Otp
 *
 * @package MessageBird\Resources
 */
class Otp extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->setObject(new Objects\Otp);
        $this->setResourceName('otp');

        parent::__construct($HttpClient);
    }

    /**
     * @param $object
     *
     * @return $this->Object
     *
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function generate($object)
    {
        $this->setResourceName($this->getResourceName() .'/generate');

        return $this->create($object);
    }

    /**
     * @param $object
     *
     * @return $this->Object
     *
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function verify($object)
    {
        $this->setResourceName($this->getResourceName() .'/verify');

        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $this->resourceName, (array) $object);
        return $this->processRequest($body);
    }
}
