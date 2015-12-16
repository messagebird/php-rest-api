<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;

/**
 * Class LookupHLR 
 *
 * @package MessageBird\Resources
 */
class LookupHLR extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->setObject(new Objects\HLR);
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
    public function create($hlr, $countryCode = null)
    {
        $query = null;
        if ($countryCode != null) {
            $query = array("countryCode" => $countryCode);
        }
        $ResourceName = $this->resourceName . '/' . ($hlr->msisdn) . '/hlr' ;
        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_POST, $ResourceName, $query, json_encode($hlr));
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
    public function read($phoneNumber = null, $countryCode = null)
    {
        $query = null;
        if ($countryCode != null) {
            $query = array("countryCode" => $countryCode);
        }
        $ResourceName = $this->resourceName . '/' . $phoneNumber . '/hlr' ;
        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $ResourceName, $query, null);
        return $this->processRequest($body);
    }


}
