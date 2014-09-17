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

    const CLIENT_VERSION = '1.1.2';

    /**
     * @var string
     */
    protected $endpoint = self::ENDPOINT;

    /**
     * @var Resources\Messages
     */
    public $messages;

    /**
     * @var Resources\VoiceMessage
     */
    public $voicemessages;

    /**
     * @var Resources\Hlr
     */
    public $hlr;

    /**
     * @var Resources\Balance
     */
    public $balance;

    /**
     * @var Common\HttpClient
     */
    protected $HttpClient;


    /**
     * @param $accessKey
     */
    public function __construct($accessKey = null)
    {
        $this->HttpClient = new Common\HttpClient(self::ENDPOINT);
        $this->HttpClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);

        if ($accessKey !== null) {
            $this->setAccessKey($accessKey);
        }

        $this->messages = new Resources\Messages($this->HttpClient);
        $this->hlr      = new Resources\Hlr($this->HttpClient);
        $this->balance  = new Resources\Balance($this->HttpClient);
        $this->voicemessages      = new Resources\VoiceMessage($this->HttpClient);
    }

    /**
     * @param $accessKey
     */
    public function setAccessKey ($accessKey)
    {
        $Authentication = new Common\Authentication($accessKey);
        $this->HttpClient->setAuthentication($Authentication);
    }

}
