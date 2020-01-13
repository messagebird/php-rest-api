<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;

/**
 * Class PhoneNumbers
 *
 * @package MessageBird\Resources
 */
class PhoneNumbers extends Base
{

    /**
     * @var \MessageBird\Common\HttpClient
     */
    protected $HttpClient;

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->HttpClient = $HttpClient;
        $this->setObject(new Objects\Number());
        $this->setResourceName('phone-numbers');
    }

    /**
     * @param $object
     * @param $id
     *
     * @return Objects\Number
     *
     * @internal param array $parameters
     */
    public function update($object, $id): Objects\Number
    {
        $objVars = get_object_vars($object);
        $body = [];
        foreach ($objVars as $key => $value) {
            if (null !== $value) {
                $body[$key] = $value;
            }
        }

        $ResourceName = $this->resourceName . ($id ? '/' . $id : null);
        $body = json_encode($body);

        // This override is only needed to use the PATCH http method
        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_PATCH, $ResourceName, false, $body);
        return $this->processRequest($body);
    }
}
?>
