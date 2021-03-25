<?php

namespace MessageBird\Resources;

use InvalidArgumentException;
use MessageBird\Common;
use MessageBird\Objects;

/**
 * Class LookupHlr
 *
 * @package MessageBird\Resources
 */
class LookupHlr extends Base
{

    /**
     * @param Common\HttpClient $httpClient
     */
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->setObject(new Objects\Hlr);
        $this->setResourceName('lookup');

        parent::__construct($httpClient);
    }

    /**
     * @param Objects\Hlr $hlr
     * @param string|null $countryCode
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|null
     *
     * @throws \MessageBird\Exceptions\HttpException
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function create($hlr, $countryCode = null)
    {
        if (empty($hlr->msisdn)) {
            throw new InvalidArgumentException('The phone number ($hlr->msisdn) cannot be empty.');
        }

        $query = null;
        if ($countryCode !== null) {
            $query = ["countryCode" => $countryCode];
        }
        $resourceName = $this->resourceName . '/' . ($hlr->msisdn) . '/hlr' ;
        list(, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_POST, $resourceName, $query, json_encode($hlr));
        return $this->processRequest($body);
    }

    /**
     * @no-named-arguments
     *
     * @param mixed $phoneNumber
     * @param string|null  $countryCode
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|null
     *
     * @throws \MessageBird\Exceptions\HttpException
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function read($phoneNumber = null, $countryCode = null)
    {
        if (empty($phoneNumber)) {
            throw new InvalidArgumentException('The phone number cannot be empty.');
        }

        $query = null;
        if ($countryCode !== null) {
            $query = ["countryCode" => $countryCode];
        }
        $resourceName = $this->resourceName . '/' . $phoneNumber . '/hlr' ;
        list(, , $body) = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $resourceName, $query, null);
        return $this->processRequest($body);
    }
}
