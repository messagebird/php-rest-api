<?php

namespace MessageBird\Common;

use MessageBird\Common;
use MessageBird\Exceptions;

/**
 * Class HttpClient
 *
 * @package MessageBird\Common
 */
class HttpClient
{
    const REQUEST_GET = 'GET';
    const REQUEST_POST = 'POST';
    const REQUEST_DELETE = 'DELETE';
    const REQUEST_PUT = 'PUT';
    const REQUEST_PATCH = "PATCH";

    const HTTP_NO_CONTENT = 204;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * @var array
     */
    protected $userAgent = array();

    /**
     * @var Common\Authentication
     */
    protected $Authentication;

    /**
     * @var int
     */
    private $timeout = 10;

    /**
     * @var int
     */
    private $connectionTimeout = 2;

    /**
     * @var array
     */
    private $headers = array();

    /**
     * @var array
     */
    private $httpOptions = array();

    /**
     * @param string $endpoint
     * @param int    $timeout           > 0
     * @param int    $connectionTimeout >= 0
     * @param array  $headers
     */
    public function __construct($endpoint, $timeout = 10, $connectionTimeout = 2, $headers = array())
    {
        $this->endpoint = $endpoint;

        if (!is_int($timeout) || $timeout < 1) {
            throw new \InvalidArgumentException(sprintf(
                'Timeout must be an int > 0, got "%s".',
                is_object($timeout) ? get_class($timeout) : gettype($timeout).' '.var_export($timeout, true))
            );
        }

        $this->timeout = $timeout;

        if (!is_int($connectionTimeout) || $connectionTimeout < 0) {
            throw new \InvalidArgumentException(sprintf(
                'Connection timeout must be an int >= 0, got "%s".',
                is_object($connectionTimeout) ? get_class($connectionTimeout) : gettype($connectionTimeout).' '.var_export($connectionTimeout, true))
            );
        }

        $this->connectionTimeout = $connectionTimeout;
        $this->headers = $headers;
    }

    /**
     * @param string $userAgent
     */
    public function addUserAgentString($userAgent)
    {
        $this->userAgent[] = $userAgent;
    }

    /**
     * @param Common\Authentication $Authentication
     */
    public function setAuthentication(Common\Authentication $Authentication)
    {
        $this->Authentication = $Authentication;
    }

    /**
     * @param string $resourceName
     * @param mixed  $query
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
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * @param $key
     * @param $value
     */
    public function addHttpOption($option, $value)
    {
        $this->httpOptions[$option] = $value;
    }

    /**
     * @param $option
     * @return mixed|null
     */
    public function getHttpOption($option)
    {
        return isset($this->httpOptions[$option]) ? $this->httpOptions[$option] : null;
    }

    /**
     * @param string      $method
     * @param string      $resourceName
     * @param mixed       $query
     * @param string|null $body
     *
     * @return array
     *
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
     */
    public function performHttpRequest($method, $resourceName, $query = null, $body = null)
    {
        $curl = curl_init();

        if ($this->Authentication === null) {
            throw new Exceptions\AuthenticateException('Can not perform API Request without Authentication');
        }

        $headers = array (
            'User-agent: ' . implode(' ', $this->userAgent),
            'Accept: application/json',
            'Content-Type: application/json',
            'Accept-Charset: utf-8',
            sprintf('Authorization: AccessKey %s', $this->Authentication->accessKey)
        );

        $headers = array_merge($headers, $this->headers);

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_HEADER, true);
        curl_setopt($curl, CURLOPT_URL, $this->getRequestUrl($resourceName, $query));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);

        foreach ($this->httpOptions as $option => $value) {
            curl_setopt($curl, $option, $value);
        }

        if ($method === self::REQUEST_GET) {
            curl_setopt($curl, CURLOPT_HTTPGET, true);
        } elseif ($method === self::REQUEST_POST) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        } elseif ($method === self::REQUEST_DELETE) {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::REQUEST_DELETE);
        } elseif ($method === self::REQUEST_PUT){
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::REQUEST_PUT);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        } elseif ($method === self::REQUEST_PATCH){
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::REQUEST_PATCH);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        }

        // Some servers have outdated or incorrect certificates, Use the included CA-bundle
        $caFile = realpath(__DIR__ . '/../ca-bundle.crt');
        if (!file_exists($caFile)) {
            throw new Exceptions\HttpException(sprintf('Unable to find CA-bundle file "%s".', __DIR__ . '/../ca-bundle.crt'));
        }

        curl_setopt($curl, CURLOPT_CAINFO, $caFile);

        $response = curl_exec($curl);

        if ($response === false) {
            throw new Exceptions\HttpException(curl_error($curl), curl_errno($curl));
        }

        $responseStatus = (int) curl_getinfo($curl, CURLINFO_HTTP_CODE);

        // Split the header and body
        $parts = explode("\r\n\r\n", $response, 3);
        $isThreePartResponse = (strpos($parts[0], "\n") === false && strpos($parts[0], 'HTTP/1.') === 0);
        list($responseHeader, $responseBody) = $isThreePartResponse ? array ($parts[1], $parts[2]) : array ($parts[0], $parts[1]);

        curl_close($curl);

        return array ($responseStatus, $responseHeader, $responseBody);
    }
}
