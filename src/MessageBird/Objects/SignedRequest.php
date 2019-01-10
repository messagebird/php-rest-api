<?php

namespace MessageBird\Objects;

/**
 * Class SignedRequest
 *
 * @package MessageBird\Objects
 *
 * @link https://developers.messagebird.com/docs/verify-http-requests
 */
class SignedRequest extends Base
{
    const BODY_HASH_ALGO = 'sha256';

    /**
     * The timestamp passed in the MessageBird-Request-Timestamp header of the request.
     *
     * @var string
     */
    protected $requestTimestamp;

    /**
     * The request body.
     *
     * @var string
     */
    protected $body;

    /**
     * The query parameters for the request.
     *
     * @var array
     */
    protected $queryParameters = array();

    /**
     * The signature passed in the MessageBird-Signature header of the request.
     *
     * @var string
     */
    protected $signature;

    /**
     * Create a new SignedRequest from PHP globals.
     *
     * @return SignedRequest
     */
    public static function createFromGlobals()
    {
        $body = file_get_contents('php://input');
        $queryParameters = $_GET;
        $requestTimestamp = $_SERVER['HTTP_MESSAGEBIRD_REQUEST_TIMESTAMP'];
        $signature = $_SERVER['HTTP_MESSAGEBIRD_SIGNATURE'];

        $signedRequest = new SignedRequest();
        $signedRequest->loadFromArray(compact('body', 'queryParameters', 'requestTimestamp', 'signature'));

        return $signedRequest;
    }

    /**
     * Create a SignedRequest from the provided data.
     *
     * @param string|array $query The query string from the request
     * @param array $headers The headers from the request
     * @param string $body The request body
     * @return SignedRequest
     */
    public static function create($query, $headers, $body)
    {
        if (is_string($query)) {
            $queryParameters = array();
            parse_str($query, $queryParameters);
        } elseif (is_array($query)) {
            $queryParameters = $query;
        } else {
            throw new \InvalidArgumentException('The "$query" parameter should be either a string or an array.');
        }

        if (array_key_exists('MessageBird-Request-Timestamp', $headers)) {
            $requestTimestamp = $headers['MessageBird-Request-Timestamp'];
        } else {
            throw new \InvalidArgumentException('The "MessageBird-Request-Timestamp" header is missing.');
        }

        if (array_key_exists('MessageBird-Signature', $headers)) {
            $signature = $headers['MessageBird-Signature'];
        } else {
            throw new \InvalidArgumentException('The "MessageBird-Signature" header is missing.');
        }

        $signedRequest = new SignedRequest();
        $signedRequest->loadFromArray(compact('body', 'queryParameters', 'requestTimestamp', 'signature'));

        return $signedRequest;
    }

    /**
     * Get the request timestamp for the signed request.
     *
     * @return string
     */
    public function getRequestTimestamp()
    {
        return $this->requestTimestamp;
    }

    /**
     * Get the request query parameters in sorted order.
     *
     * @return string
     */
    public function getSortedQueryParameters()
    {
        ksort($this->queryParameters, SORT_STRING);

        return http_build_query($this->queryParameters);
    }

    /**
     * Get the SHA-256 checksum of the request body.
     *
     * @return string
     */
    public function getBodyChecksum()
    {
        return hash(self::BODY_HASH_ALGO, $this->body, true);
    }

    /**
     * Get the expected signature (in raw format).
     *
     * @return string
     */
    public function getSignature()
    {
        return base64_decode($this->signature);
    }
}
