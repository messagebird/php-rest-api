<?php

namespace MessageBird\Common;

use MessageBird\Exceptions;
use MessageBird\Common;

/**
 * @package MessageBird\Common
 */
class HttpClient
{
    /**
     * Request method constants.
     */
    const REQUEST_GET = 'GET';
    const REQUEST_POST = 'POST';
    const REQUEST_DELETE = 'DELETE';
    const REQUEST_PUT = 'PUT';

    /**
     * Response code constants.
     */
    const HTTP_NO_CONTENT = 204;

    /**
     * Relative path to CA Bundle file.
     */
    const CA_BUNDLE_PATH_RELATIVE = '/../ca-bundle.crt';

    /**
     * Default timeout values.
     */
    const TIMEOUT_DEFAULT = 10;
    const CONNECTION_TIMEOUT_DEFAULT = 2;

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
    private $timeout = self::TIMEOUT_DEFAULT;

    /**
     * @var int
     */
    private $connectionTimeout = self::CONNECTION_TIMEOUT_DEFAULT;

    /**
     * @var resource
     */
    private $curl;

    /**
     * @param string $endpoint
     * @param int $timeout > 0
     * @param int $connectionTimeout >= 0
     *
     * @throws \InvalidArgumentException if timeout settings are invalid
     */
    public function __construct(
        $endpoint,
        $timeout = self::TIMEOUT_DEFAULT,
        $connectionTimeout = self::CONNECTION_TIMEOUT_DEFAULT
    ) {
        $this->assertTimeoutValid($timeout);
        $this->assertConnectionTimeoutValid($connectionTimeout);

        $this->endpoint = $endpoint;
        $this->timeout = $timeout;
        $this->connectionTimeout = $connectionTimeout;
    }

    /**
     * @param $timeout
     */
    private function assertTimeoutValid($timeout)
    {
        if (!$this->isValidTimeout($timeout)) {
            throw $this->createInvalidArgumentTypeException('Timeout must be an int > 0, got "%s".', $timeout);
        }
    }

    /**
     * @param $timeout
     *
     * @return bool
     */
    private function isValidTimeout($timeout)
    {
        return is_int($timeout) && $timeout > 0;
    }

    /**
     * @param string $message
     * @param mixed $argument
     *
     * @return \InvalidArgumentException
     */
    private function createInvalidArgumentTypeException($message, $argument)
    {
        return new \InvalidArgumentException(sprintf($message, $this->getTypeString($argument)));
    }

    /**
     * @param $argument
     *
     * @return string
     */
    private function getTypeString($argument)
    {
        if (is_object($argument)) {
            return get_class($argument);
        } else {
            return gettype($argument) . ' ' . var_export($argument, true);
        }
    }

    /**
     * @param $connectionTimeout
     */
    private function assertConnectionTimeoutValid($connectionTimeout)
    {
        if (!$this->isValidConnectionTimeout($connectionTimeout)) {
            throw $this->createInvalidArgumentTypeException(
                'Connection timeout must be an int >= 0, got "%s".',
                $connectionTimeout
            );
        }
    }

    /**
     * @param $connectionTimeout
     *
     * @return bool
     */
    private function isValidConnectionTimeout($connectionTimeout)
    {
        return is_int($connectionTimeout) && $connectionTimeout >= 0;
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
     * @param string $method
     * @param string $resourceName
     * @param mixed $query
     * @param string|null $body
     *
     * @return array
     *
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\HttpException
     */
    public function performHttpRequest($method, $resourceName, $query = null, $body = null)
    {
        $this->assertHasAuthentication();
        $this->openCurlConnection();
        $this->prepareHttpRequest($method, $resourceName, $query, $body);
        $responseArray = $this->executeHttpRequest();
        $this->closeCurlConnection();

        return $responseArray;
    }

    /**
     * @throws Exceptions\AuthenticateException
     */
    private function assertHasAuthentication()
    {
        if ($this->Authentication === null) {
            throw new Exceptions\AuthenticateException('Can not perform API Request without Authentication');
        }
    }

    /**
     */
    private function openCurlConnection()
    {
        $this->curl = curl_init();
    }

    /**
     * @param string $method
     * @param string $resourceName
     * @param mixed $query
     * @param string|null $body
     */
    private function prepareHttpRequest($method, $resourceName, $query = null, $body = null)
    {
        $this->setCommonCurlOptions($resourceName, $query);
        $this->setMethodSpecificCurlOptions($method, $body);
        // Some servers have outdated or incorrect certificates, Use the included CA-bundle
        $this->setCurlCaBundle();
    }

    /**
     * @param $resourceName
     * @param mixed $query
     */
    private function setCommonCurlOptions($resourceName, $query = null)
    {
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->getHeaderArray());
        curl_setopt($this->curl, CURLOPT_HEADER, true);
        curl_setopt($this->curl, CURLOPT_URL, $this->getRequestUrl($resourceName, $query));
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($this->curl, CURLOPT_CONNECTTIMEOUT, $this->connectionTimeout);
    }

    /**
     * @return string[]
     */
    private function getHeaderArray()
    {
        return array(
            'User-agent: ' . implode(' ', $this->userAgent),
            'Accept: application/json',
            'Content-Type: application/json',
            'Accept-Charset: utf-8',
            sprintf('Authorization: AccessKey %s', $this->Authentication->accessKey)
        );
    }

    /**
     * @param string $resourceName
     * @param mixed $query
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
     * @param $method
     * @param string|null $body
     */
    private function setMethodSpecificCurlOptions($method, $body = null)
    {
        if ($method === self::REQUEST_GET) {
            curl_setopt($this->curl, CURLOPT_HTTPGET, true);
        } elseif ($method === self::REQUEST_POST) {
            curl_setopt($this->curl, CURLOPT_POST, true);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $body);
        } elseif ($method === self::REQUEST_DELETE) {
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, self::REQUEST_DELETE);
        } elseif ($method === self::REQUEST_PUT) {
            curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, self::REQUEST_PUT);
            curl_setopt($this->curl, CURLOPT_POSTFIELDS, $body);
        }
    }

    /**
     */
    private function setCurlCaBundle()
    {
        $this->assertCaBundleExists();

        curl_setopt($this->curl, CURLOPT_CAINFO, $this->getCaBundleRealPath());
    }

    /**
     * @throws Exceptions\HttpException
     */
    private function assertCaBundleExists()
    {
        if (!$this->isCaBundleFileExists()) {
            throw new Exceptions\HttpException(
                sprintf('Unable to find CA-bundle file "%s".', $this->getCaBundlePath())
            );
        }
    }

    /**
     * @return bool
     */
    private function isCaBundleFileExists()
    {
        return file_exists($this->getCaBundleRealPath());
    }

    /**
     * @return string
     */
    private function getCaBundleRealPath()
    {
        return realpath($this->getCaBundlePath());
    }

    /**
     * @return string
     */
    private function getCaBundlePath()
    {
        return __DIR__ . self::CA_BUNDLE_PATH_RELATIVE;
    }

    /**
     * @return array
     * @throws Exceptions\HttpException
     */
    private function executeHttpRequest()
    {
        $response = curl_exec($this->curl);

        $this->assertIsValidResponse($response);

        return $this->getResponseArray($response);
    }

    /**
     * @param $response
     *
     * @throws Exceptions\HttpException
     */
    private function assertIsValidResponse($response)
    {
        if ($response === false) {
            throw new Exceptions\HttpException(curl_error($this->curl), curl_errno($this->curl));
        }
    }

    /**
     * @param string $response
     *
     * @return array
     */
    private function getResponseArray($response)
    {
        $responseStatus = $this->getCurlResponseStatus();
        $responseHeaderAndBody = $this->splitResponseIntoHeaderAndBody($response);

        return array_merge(array($responseStatus), $responseHeaderAndBody);
    }

    /**
     * @return int
     */
    private function getCurlResponseStatus()
    {
        return (int)curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
    }

    /**
     * @param string $response
     *
     * @return array
     */
    private function splitResponseIntoHeaderAndBody($response)
    {
        $parts = explode("\r\n\r\n", $response, 3);

        if ($parts[0] === 'HTTP/1.1 100 Continue') {
            return array($parts[1], $parts[2]);
        } else {
            return array($parts[0], $parts[1]);
        }
    }

    /**
     */
    private function closeCurlConnection()
    {
        curl_close($this->curl);
    }
}
