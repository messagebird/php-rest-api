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
    const CHATAPI_ENDPOINT = 'https://chat.messagebird.com/1';

    const CLIENT_VERSION = '1.6.2';

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
     * @var Resources\Verify
     */
    public $verify;

    /**
     * @var Resources\Balance
     */
    public $balance;

    /**
     * @var Resources\Lookup
     */
    public $lookup;

    /**
     * @var Resources\LookupHlr
     */
    public $lookupHlr;

    /**
     * @var Resources\Chat\Message
     */
    public $chatMessages;

    /**
     * @var Resources\Chat\Channel
     */
    public $chatChannels;

    /**
     * @var Resources\Chat\Platform
     */
    public $chatPlatforms;

    /**
     * @var Resources\Chat\Contact
     */
    public $chatContacts;

    /**
     * @var Common\HttpClient
     */
    protected $HttpClient;

    /**
     * @var Common\HttpClient
     */
    protected $ChatAPIHttpClient;

    /**
     * @param string            $accessKey
     * @param Common\HttpClient $httpClient
     */
    public function __construct($accessKey = null, Common\HttpClient $httpClient = null)
    {
        if ($httpClient === null) {
            $this->ChatAPIHttpClient = new Common\HttpClient(self::CHATAPI_ENDPOINT);
            $this->HttpClient = new Common\HttpClient(self::ENDPOINT);
        } else {
            $this->ChatAPIHttpClient = $httpClient;
            $this->HttpClient = $httpClient;
        }

        $this->HttpClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);
        $this->HttpClient->addUserAgentString($this->getPhpVersion());

        $this->ChatAPIHttpClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);
        $this->ChatAPIHttpClient->addUserAgentString($this->getPhpVersion());

        if ($accessKey !== null) {
            $this->setAccessKey($accessKey);
        }

        $this->messages      = new Resources\Messages($this->HttpClient);
        $this->hlr           = new Resources\Hlr($this->HttpClient);
        $this->verify        = new Resources\Verify($this->HttpClient);
        $this->balance       = new Resources\Balance($this->HttpClient);
        $this->voicemessages = new Resources\VoiceMessage($this->HttpClient);
        $this->lookup        = new Resources\Lookup($this->HttpClient);
        $this->lookupHlr     = new Resources\LookupHlr($this->HttpClient);
        $this->chatMessages  = new Resources\Chat\Message($this->ChatAPIHttpClient);
        $this->chatChannels  = new Resources\Chat\Channel($this->ChatAPIHttpClient);
        $this->chatPlatforms = new Resources\Chat\Platform($this->ChatAPIHttpClient);
        $this->chatContacts  = new Resources\Chat\Contact($this->ChatAPIHttpClient);
    }

    /**
     * @param $accessKey
     */
    public function setAccessKey ($accessKey)
    {
        $Authentication = new Common\Authentication($accessKey);

        $this->ChatAPIHttpClient->setAuthentication($Authentication);
        $this->HttpClient->setAuthentication($Authentication);
    }

    /**
     * @return string
     */
    private function getPhpVersion()
    {
        if (!defined('PHP_VERSION_ID')) {
            $version = explode('.', PHP_VERSION);
            define('PHP_VERSION_ID', $version[0] * 10000 + $version[1] * 100 + $version[2]);
        }

        return 'PHP/' . PHP_VERSION_ID;
    }
}
