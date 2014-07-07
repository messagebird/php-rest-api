<?php

namespace MessageBird;

/**
 * Class Client
 *
 * @package MessageBird
 */
class Client
{

    const ENDPOINT = 'https://rest.messagebird.com';

    const CLIENT_VERSION = '1.0.0';

    /**
     * @var string
     */
    protected $endpoint = self::ENDPOINT;

    /**
     * @var Resources\Messages
     */
    public $messages;

    /**
     * @var Resources\Hlr
     */
    public $hlr;

    /**
     * @var Resources\Balance
     */
    public $balance;


    /**
     * @param $accessKey
     */
    public function __construct($accessKey)
    {
        $Authentication = new Common\Authentication($accessKey);

        $HttpClient = new Common\HttpClient(self::ENDPOINT);
        $HttpClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);
        $HttpClient->setAuthentication($Authentication);

        $this->messages = new Resources\Messages($HttpClient);
        $this->hlr      = new Resources\Hlr($HttpClient);
        $this->balance  = new Resources\Balance($HttpClient);
    }


}