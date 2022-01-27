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
 * Class Verify
 *
 * @package MessageBird\Resources
 */
class Lookup extends Base
{
    public function __construct(Common\HttpClient $httpClient)
    {
        $this->object = new Objects\Lookup();
        $this->setResourceName('lookup');

        parent::__construct($httpClient);
    }

    /**
     * @no-named-arguments
     *
     * @param string|int $phoneNumber
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
        $resourceName = $this->resourceName . '/' . $phoneNumber;
        [, , $body] = $this->httpClient->performHttpRequest(Common\HttpClient::REQUEST_GET, $resourceName, $query);
        return $this->processRequest($body);
    }
}
