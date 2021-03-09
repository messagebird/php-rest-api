<?php

namespace MessageBird\Objects;

use MessageBird\Exceptions\ValidationException;

/**
 * Class SignedRequest
 *
 * @package MessageBird\Objects
 *
 * @link https://developers.messagebird.com/docs/verify-http-requests
 */
class SignedRequest extends Base
{
    /**
     * The timestamp passed in the MessageBird-Request-Timestamp header of the request.
     *
     * @var string
     */
    public $requestTimestamp;

    /**
     * The request body.
     *
     * @var string
     */
    public $body;

    /**
     * The query parameters for the request.
     *
     * @var array
     */
    public $queryParameters = [];

    /**
     * The signature passed in the MessageBird-Signature header of the request.
     *
     * @var string
     */
    public $signature;

    /**
     * Create a new SignedRequest from PHP globals.
     *
     * @return SignedRequest
     * @throws ValidationException when a required parameter is missing.
     */
    public static function createFromGlobals()
    {
        $body = file_get_contents('php://input');
        $queryParameters = $_GET;
        $requestTimestamp = isset($_SERVER['HTTP_MESSAGEBIRD_REQUEST_TIMESTAMP']) ?
            (int)$_SERVER['HTTP_MESSAGEBIRD_REQUEST_TIMESTAMP'] : null;
        $signature = $_SERVER['HTTP_MESSAGEBIRD_SIGNATURE'] ?? null;

        $signedRequest = new SignedRequest();
        $signedRequest->loadFromArray(compact('body', 'queryParameters', 'requestTimestamp', 'signature'));

        return $signedRequest;
    }

    /**
     * Create a SignedRequest from the provided data.
     *
     * @param string|array $query The query string from the request
     * @param string $signature The base64-encoded signature for the request
     * @param int $requestTimestamp The UNIX timestamp for the time the request was made
     * @param string $body The request body
     * @return SignedRequest
     * @throws ValidationException when a required parameter is missing.
     */
    public static function create($query, $signature, $requestTimestamp, $body)
    {
        if (is_string($query)) {
            $queryParameters = [];
            parse_str($query, $queryParameters);
        } else {
            $queryParameters = $query;
        }

        $signedRequest = new SignedRequest();
        $signedRequest->loadFromArray(compact('body', 'queryParameters', 'requestTimestamp', 'signature'));

        return $signedRequest;
    }

    /**
     * {@inheritdoc}
     * @throws ValidationException when a required parameter is missing.
     */
    public function loadFromArray($params)
    {
        if (!isset($params['requestTimestamp']) || !is_int($params['requestTimestamp'])) {
            throw new ValidationException('The "requestTimestamp" value is missing or invalid.');
        }

        if (!isset($params['signature']) || !is_string($params['signature'])) {
            throw new ValidationException('The "signature" parameter is missing.');
        }

        if (!isset($params['queryParameters']) || !is_array($params['queryParameters'])) {
            throw new ValidationException('The "queryParameters" parameter is missing or invalid.');
        }

        if (!isset($params['body']) || !is_string($params['body'])) {
            throw new ValidationException('The "body" parameter is missing.');
        }

        return parent::loadFromArray($params);
    }
}
