<?php

namespace MessageBird\Resources;

use InvalidArgumentException;
use MessageBird\Common;
use MessageBird\Objects;

/**
 * Class Verify
 *
 * @package MessageBird\Resources
 */
class Lookup extends Base
{

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->setObject(new Objects\Lookup);
        $this->setResourceName('lookup');

        parent::__construct($httpClient);
    }

    /**
     * @param string|int $phoneNumber
     * @param string     $countryCode
     *
     * @return $this->object
     *
     * @throws \MessageBird\Exceptions\HttpException
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function read($phoneNumber = null, $countryCode = null)
    {
        if(empty($phoneNumber)) {
            throw new InvalidArgumentException('The phone number cannot be empty.');
        }
        $query = null;
        if ($countryCode !== null) {
            $query = ["countryCode" => $countryCode];
        }
        $resourceName = $this->resourceName . '/' . $phoneNumber;
        list(, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $resourceName, $query);
        return $this->processRequest($body);
    }
}
