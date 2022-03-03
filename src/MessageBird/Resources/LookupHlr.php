<?php

namespace MessageBird\Resources;

use InvalidArgumentException;
use MessageBird\Common;
use MessageBird\Exceptions\AuthenticateException;
use MessageBird\Exceptions\HttpException;
use MessageBird\Exceptions\RequestException;
use MessageBird\Exceptions\ServerException;
use MessageBird\Objects;

/**
 * Class LookupHlr
 *
 * @package MessageBird\Resources
 */
class LookupHlr extends Base
{
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->object = new Objects\Hlr();
        $this->setResourceName('lookup');

        parent::__construct($httpClient);
    }

    /**
     * @param Objects\Hlr $object
     * @param array|null $query
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|null
     *
     * @throws HttpException
     * @throws RequestException
     * @throws ServerException
     * @throws \JsonException
     * @throws AuthenticateException
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
        $resourceName = $this->resourceName . '/' . ($hlr->msisdn) . '/hlr';
        [, , $body] = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_POST,
            $resourceName,
            $query,
            json_encode($hlr, \JSON_THROW_ON_ERROR)
        );
        return $this->processRequest($body);
    }

    /**
     * @no-named-arguments
     *
     * @param mixed $phoneNumber
     * @param string|null $countryCode
     *
     * @return Objects\Balance|Objects\Conversation\Conversation|Objects\Hlr|Objects\Lookup|Objects\Message|Objects\Verify|Objects\VoiceMessage|null
     *
     * @throws HttpException
     * @throws RequestException
     * @throws ServerException
     * @throws AuthenticateException
     */
    public function read($phoneNumber = null, ?string $countryCode = null)
    {
        if (empty($phoneNumber)) {
            throw new InvalidArgumentException('The phone number cannot be empty.');
        }

        $query = null;
        if ($countryCode !== null) {
            $query = ["countryCode" => $countryCode];
        }
        $resourceName = $this->resourceName . '/' . $phoneNumber . '/hlr';
        [, , $body] = $this->httpClient->performHttpRequest(
            Common\HttpClient::REQUEST_GET,
            $resourceName,
            $query,
            null
        );
        return $this->processRequest($body);
    }
}
