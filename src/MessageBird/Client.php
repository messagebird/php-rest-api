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

    const CLIENT_VERSION = '1.1.11';

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
     * @var Resources\Otp
     */
    public $otp;

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
    public function __construct($accessKey = null, Common\HttpClient $httpClient = null)
    {
        if ($httpClient == null) {
            $this->HttpClient = new Common\HttpClient(self::ENDPOINT);
        } else {
            $this->HttpClient = $httpClient;
        }
        $this->HttpClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);
        $this->HttpClient->addUserAgentString($this->getPhpVersion());

        if ($accessKey !== null) {
            $this->setAccessKey($accessKey);
        }
        $this->messages = new Resources\Messages($this->HttpClient);
        $this->hlr      = new Resources\Hlr($this->HttpClient);
        $this->otp      = new Resources\Otp($this->HttpClient);
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

    private function getPhpVersion()
    {
        if (!defined('PHP_VERSION_ID')) {
            $version = explode('.', PHP_VERSION);
            define('PHP_VERSION_ID', ($version[0] * 10000 + $version[1] * 100 + $version[2]));
        }
        return "PHP/" . PHP_VERSION_ID;
    }

}
