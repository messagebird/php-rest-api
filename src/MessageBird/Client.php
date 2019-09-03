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
    const CONVERSATIONSAPI_ENDPOINT = 'https://conversations.messagebird.com/v1';
    const VOICEAPI_ENDPOINT = 'https://voice.messagebird.com';

    const ENABLE_CONVERSATIONSAPI_WHATSAPP_SANDBOX = 'ENABLE_CONVERSATIONSAPI_WHATSAPP_SANDBOX';
    const CONVERSATIONSAPI_WHATSAPP_SANDBOX_ENDPOINT = 'https://whatsapp-sandbox.messagebird.com/v1';

    const CLIENT_VERSION = '1.15.0';

    /**
     * @var string
     */
    protected $endpoint = self::ENDPOINT;

    /**
     * @var Resources\Messages
     */
    public $messages;

    /**
     * @var Resources\Contacts
     */
    public $contacts;

    /**
     * @var Resources\Groups
     */
    public $groups;

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
     * @var Resources\MmsMessages
     */
    public $mmsMessages;

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
     * @var Resources\Voice\Calls
     */
    public $voiceCalls;

    /**
     * @var Resources\Voice\CallFlows
     */
    public $voiceCallFlows;

    /**
     * @var Resources\Voice\Legs
     */
    public $voiceLegs;

    /**
     * @var Resources\Voice\Recordings
     */
    public $voiceRecordings;

    /**
     * @var Resources\Voice\Transcriptions
     */
    public $voiceTranscriptions;

    /**
     * @var Resources\Voice\Webhooks
     */
    public $voiceWebhooks;

    /**
     * @var Resources\Conversation\Conversations;
     */
    public $conversations;

    /**
     * @var Resources\Conversation\Messages;
     */
    public $conversationMessages;

    /**
     * @var Resources\Conversation\Webhooks;
     */
    public $conversationWebhooks;

    /**
     * @var Common\HttpClient
     */
    protected $HttpClient;

    /**
     * @var Common\HttpClient
     */
    protected $ChatAPIHttpClient;

    /**
     * @var Common\HttpClient
     */
    protected $ConversationsAPIHttpClient;

    /**
     * @var Common\HttpClient
     */
    protected $VoiceAPIHttpClient;

    /**
     * @param string            $accessKey
     * @param Common\HttpClient $httpClient
     */
    public function __construct($accessKey = null, Common\HttpClient $httpClient = null, array $config = [])
    {
        if ($httpClient === null) {
            $this->ChatAPIHttpClient = new Common\HttpClient(self::CHATAPI_ENDPOINT);
            $this->ConversationsAPIHttpClient = new Common\HttpClient(in_array(self::ENABLE_CONVERSATIONSAPI_WHATSAPP_SANDBOX, $config) ? self::CONVERSATIONSAPI_WHATSAPP_SANDBOX_ENDPOINT : self::CONVERSATIONSAPI_ENDPOINT);
            $this->HttpClient = new Common\HttpClient(self::ENDPOINT);
            $this->VoiceAPIHttpClient = new Common\HttpClient(self::VOICEAPI_ENDPOINT, 10, 2, array(
                'X-MessageBird-Version' => '20170314',
           ));
        } else {
            $this->ChatAPIHttpClient = $httpClient;
            $this->ConversationsAPIHttpClient = $httpClient;
            $this->HttpClient = $httpClient;
            $this->VoiceAPIHttpClient = $httpClient;
        }

        $this->HttpClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);
        $this->HttpClient->addUserAgentString($this->getPhpVersion());

        $this->ChatAPIHttpClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);
        $this->ChatAPIHttpClient->addUserAgentString($this->getPhpVersion());

        $this->ConversationsAPIHttpClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);
        $this->ConversationsAPIHttpClient->addUserAgentString($this->getPhpVersion());

        $this->VoiceAPIHttpClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);
        $this->VoiceAPIHttpClient->addUserAgentString($this->getPhpVersion());

        if ($accessKey !== null) {
            $this->setAccessKey($accessKey);
        }

        $this->messages             = new Resources\Messages($this->HttpClient);
        $this->hlr                  = new Resources\Hlr($this->HttpClient);
        $this->verify               = new Resources\Verify($this->HttpClient);
        $this->balance              = new Resources\Balance($this->HttpClient);
        $this->voicemessages        = new Resources\VoiceMessage($this->HttpClient);
        $this->lookup               = new Resources\Lookup($this->HttpClient);
        $this->lookupHlr            = new Resources\LookupHlr($this->HttpClient);
        $this->chatMessages         = new Resources\Chat\Message($this->ChatAPIHttpClient);
        $this->chatChannels         = new Resources\Chat\Channel($this->ChatAPIHttpClient);
        $this->chatPlatforms        = new Resources\Chat\Platform($this->ChatAPIHttpClient);
        $this->chatContacts         = new Resources\Chat\Contact($this->ChatAPIHttpClient);
        $this->voiceCallFlows       = new Resources\Voice\CallFlows($this->VoiceAPIHttpClient);
        $this->voiceCalls           = new Resources\Voice\Calls($this->VoiceAPIHttpClient);
        $this->voiceLegs            = new Resources\Voice\Legs($this->VoiceAPIHttpClient);
        $this->voiceRecordings      = new Resources\Voice\Recordings($this->VoiceAPIHttpClient);
        $this->voiceTranscriptions  = new Resources\Voice\Transcriptions($this->VoiceAPIHttpClient);
        $this->voiceWebhooks        = new Resources\Voice\Webhooks($this->VoiceAPIHttpClient);
        $this->mmsMessages          = new Resources\MmsMessages($this->HttpClient);
        $this->contacts             = new Resources\Contacts($this->HttpClient);
        $this->groups               = new Resources\Groups($this->HttpClient);
        $this->conversations        = new Resources\Conversation\Conversations($this->ConversationsAPIHttpClient);
        $this->conversationMessages = new Resources\Conversation\Messages($this->ConversationsAPIHttpClient);
        $this->conversationWebhooks = new Resources\Conversation\Webhooks($this->ConversationsAPIHttpClient);
    }

    /**
     * @param $accessKey
     */
    public function setAccessKey ($accessKey)
    {
        $Authentication = new Common\Authentication($accessKey);

        $this->ChatAPIHttpClient->setAuthentication($Authentication);
        $this->ConversationsAPIHttpClient->setAuthentication($Authentication);
        $this->HttpClient->setAuthentication($Authentication);
        $this->VoiceAPIHttpClient->setAuthentication($Authentication);
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
