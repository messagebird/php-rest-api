<?php

namespace MessageBird\Common;

use MessageBird\Exceptions;
use MessageBird\Common;

/**
 * Class HttpClient
 *
 * @package MessageBird\Common
 */
class HttpClient
{
    const REQUEST_GET = "GET";
    const REQUEST_POST = "POST";
    const REQUEST_DELETE = "DELETE";

    const HTTP_NO_CONTENT = 204;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var array
     */
    protected $userAgent = array ();

    /**
     * @var Common\Authentication
     */
    protected $Authentication;

    /**
     * @param string $endpoint
     */
    public function __construct($endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @param $string
     */
    public function addUserAgentString($string)
    {
        $this->userAgent[] = $string;
    }

    /**
     * @param Common\Authentication $Authentication
     */
    public function setAuthentication(Common\Authentication $Authentication)
    {
        $this->Authentication = $Authentication;
    }

    /**
     * @param $resourceName
     * @param $query
     *
     * @return string
     */
    public function getRequestUrl($resourceName, $query)
    {
        $requestUrl = $this->endpoint . '/' . $resourceName;
        if ($query) {
            if (is_array($query)) {
                $query = http_build_query($query);
            }
            $requestUrl .= '?' . $query;
        }
        return $requestUrl;
    }

    /**
     * @param      $method
     * @param      $resourceName
     * @param null $query
     * @param null $body
     *
     * @return array
     * @throws Exceptions\HttpException
     */
    public function performHttpRequest($method, $resourceName, $query = null, $body = null)
    {
        $curl = curl_init();

        $headers = array (
            'User-agent: ' . implode(' ', $this->userAgent),
            'Accepts: application/json',
            "Content-Type: application/json",
            "Accept-Charset: utf-8",
            sprintf("Authorization: AccessKey %s", $this->Authentication->accessKey)
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_URL, $this->getRequestUrl($resourceName, $query));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 2);

        if ($method === self::REQUEST_GET) {
            curl_setopt($curl, CURLOPT_HTTPGET, true);
        } elseif ($method === self::REQUEST_POST) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        } elseif ($method === self::REQUEST_DELETE) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::REQUEST_DELETE);
        }

        // Some servers have outdated or incorrect certificates, Use the included CA-bundle
        $caFile = realpath(dirname(__FILE__) . "/../ca-bundle.crt");
        if (!file_exists($caFile)) {
            throw new Exceptions\HttpException('Unable to find CA-bundle file: ' . $caFile);
        }
        curl_setopt($curl, CURLOPT_CAINFO, $caFile);

        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exceptions\HttpException(curl_error($curl), curl_errno($curl));
        }

        $responseStatus = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Split the header and body
        $parts = explode("\r\n\r\n", $response, 3);
        list($responseHeader, $responseBody) = ($parts[0] == 'HTTP/1.1 100 Continue') ? array ($parts[1], $parts[2]) : array ($parts[0], $parts[1]);

        curl_close($curl);

        return array ($responseStatus, $responseHeader, $responseBody);
    }

}
