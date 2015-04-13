<?php

namespace MessageBird\Resources;

use MessageBird\Common;
use MessageBird\Exceptions;
use MessageBird\Objects;

/**
 * Class Base
 *
 * @package MessageBird\Resources
 */
class Base
{

    /**
     * @var \MessageBird\Common\HttpClient
     */
    protected $HttpClient;

    /**
     * @var string The resource name as it is known at the server
     */
    protected $resourceName;

    /**
     * @var Objects\Hlr|Objects\Message|Objects\Balance
     */
    protected $Object;

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->HttpClient = $HttpClient;
    }

    /**
     * @param $resourceName
     */
    public function setResourceName($resourceName)
    {
        $this->resourceName = $resourceName;
    }

    /**
     * @return string
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * @param $Object
     */
    public function setObject($Object)
    {
        $this->Object = $Object;
    }

    /**
     * @return Objects\Balance|Objects\Hlr|Objects\Message
     */
    public function getObject()
    {
        return $this->Object;
    }

    /**
     * @param $object
     *
     * @return $this->Object
     *
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function create($object)
    {
        $body = json_encode($object);
        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_POST, $this->resourceName, $query = null, $body);
        return $this->processRequest($body);
    }

    /**
     * Add the parameters to the resourceName for use in a GET request.
     * @author Lawri van Buël
     * @param array $parameters
     * @return string
     */
    private function prepGetParameters(array $parameters) {
        $getOptions = "";
        foreach ($parameters as $key => $value) {
            $getOptions.="&$key=$value";
        }
        if(strlen($getOptions)>1){
            $getOptions="?".substr($getOptions,1,strlen($getOptions));
        }
        else {
            $getOptions = "";
        }
        return $this->resourceName.$getOptions;
    }
    
    /**
     * Modified by @author to make the get request include the parameters.
     * get modification is done through a helper function.
     * @author Lawri van Buël
     * @param array $parameters
     * @return Objects\BaseList|Base
     * @throws Exceptions\HttpException
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function getList($parameters = array ())
    {
        list($status, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $this->prepGetParameters($parameters), $parameters);

        if ($status === 200) {
            $body = json_decode($body);

            $Items = $body->items;
            unset($body->items);

            $BaseList = new Objects\BaseList();
            $BaseList->loadFromArray($body);

            $objectName = $this->Object;

            foreach ($Items AS $Item) {
                $Object = new $objectName($this->HttpClient);

                $Message           = $Object->loadFromArray($Item);
                $BaseList->items[] = $Message;
            }
            return $BaseList;
        } else {
            return $this->processRequest($body);
        }
    }

    /**
     * @param $id
     *
     * @return $this->Object
     *
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function read($id = null)
    {
        $ResourceName = $this->resourceName . (($id) ? '/' . $id : null);
        list(, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $ResourceName);
        return $this->processRequest($body);
    }

    /**
     * @param $id
     *
     * @return bool
     *
     * @throws Exceptions\RequestException
     * @throws Exceptions\ServerException
     */
    public function delete($id)
    {
        $ResourceName = $this->resourceName . '/' . $id;
        list($status, , $body) = $this->HttpClient->performHttpRequest(Common\HttpClient::REQUEST_DELETE, $ResourceName);

        if ($status === Common\HttpClient::HTTP_NO_CONTENT) {
            return true;
        } else {
            return $this->processRequest($body);
        }
    }

    /**
     * @param      $body
     *
     * @return $this
     * @throws \MessageBird\Exceptions\RequestException
     * @throws \MessageBird\Exceptions\ServerException
     */
    public function processRequest($body)
    {
        $body = @json_decode($body);

        if ($body === null or $body === false) {
            throw new Exceptions\ServerException('Got an invalid JSON response from the server.');
        }

        if (empty($body->errors)) {
            return $this->Object->loadFromArray($body);
        }

        $ResponseError = new Common\ResponseError($body);
        throw new Exceptions\RequestException($ResponseError->getErrorString());
    }


}
