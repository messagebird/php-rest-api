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
    const PARTNER_ACCOUNT_ENDPOINT = 'https://partner-accounts.messagebird.com';
    const NUMBERSAPI_ENDPOINT = 'https://numbers.messagebird.com/v1';

    const ENABLE_CONVERSATIONSAPI_WHATSAPP_SANDBOX = 'ENABLE_CONVERSATIONSAPI_WHATSAPP_SANDBOX';
    const CONVERSATIONSAPI_WHATSAPP_SANDBOX_ENDPOINT = 'https://whatsapp-sandbox.messagebird.com/v1';

    const CLIENT_VERSION = '2.1.0';

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
     * @var Resources\EmailMessage
     */
    public $emailmessages;

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
     * @var Resources\PhoneNumbers
     */
    public $phoneNumbers;

    /**
     * @var Resources\AvailablePhoneNumbers
     */
    public $availablePhoneNumbers;

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
     * @var Resources\Conversation\Send;
     */
    public $conversationSend;

    /**
     * @var Resources\Conversation\Webhooks;
     */
    public $conversationWebhooks;

    /**
     * @var Resources\PartnerAccount\Accounts;
     */
    public $partnerAccounts;

    /**
     * @var Common\HttpClient
     */
    protected $httpClient;

    /**
     * @var Common\HttpClient
     */
    protected $chatAPIHttpClient;

    /**
     * @var Common\HttpClient
     */
    protected $conversationsAPIHttpClient;

    /**
     * @var Common\HttpClient
     */
    protected $voiceAPIHttpClient;

    /**
     * @var Common\HttpClient
     */
    protected $partnerAccountClient;

    /**
     * @var \MessageBird\Common\HttpClient
     */
    protected $numbersAPIClient;

    /**
     * @param string            $accessKey
     * @param Common\HttpClient $httpClient
     */
    public function __construct($accessKey = null, Common\HttpClient $httpClient = null, array $config = [])
    {
        if ($httpClient === null) {
            $this->chatAPIHttpClient = new Common\HttpClient(self::CHATAPI_ENDPOINT);
            $this->conversationsAPIHttpClient = new Common\HttpClient(in_array(self::ENABLE_CONVERSATIONSAPI_WHATSAPP_SANDBOX, $config) ? self::CONVERSATIONSAPI_WHATSAPP_SANDBOX_ENDPOINT : self::CONVERSATIONSAPI_ENDPOINT);
            $this->httpClient = new Common\HttpClient(self::ENDPOINT);
            $this->voiceAPIHttpClient = new Common\HttpClient(self::VOICEAPI_ENDPOINT, 10, 2, [
                'X-MessageBird-Version' => '20170314',
           ]);
            $this->partnerAccountClient = new Common\HttpClient(self::PARTNER_ACCOUNT_ENDPOINT);
            $this->numbersAPIClient = new Common\HttpClient(self::NUMBERSAPI_ENDPOINT);
        } else {
            $this->chatAPIHttpClient = $httpClient;
            $this->conversationsAPIHttpClient = $httpClient;
            $this->httpClient = $httpClient;
            $this->voiceAPIHttpClient = $httpClient;
            $this->partnerAccountClient = $httpClient;
            $this->numbersAPIClient = $httpClient;
        }

        $this->httpClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);
        $this->httpClient->addUserAgentString($this->getPhpVersion());

        $this->chatAPIHttpClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);
        $this->chatAPIHttpClient->addUserAgentString($this->getPhpVersion());

        $this->conversationsAPIHttpClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);
        $this->conversationsAPIHttpClient->addUserAgentString($this->getPhpVersion());

        $this->voiceAPIHttpClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);
        $this->voiceAPIHttpClient->addUserAgentString($this->getPhpVersion());

        $this->partnerAccountClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);
        $this->partnerAccountClient->addUserAgentString($this->getPhpVersion());

        $this->numbersAPIClient->addUserAgentString('MessageBird/ApiClient/' . self::CLIENT_VERSION);
        $this->numbersAPIClient->addUserAgentString($this->getPhpVersion());

        if ($accessKey !== null) {
            $this->setAccessKey($accessKey);
        }

        $this->messages = new Resources\Messages($this->httpClient);
        $this->hlr = new Resources\Hlr($this->httpClient);
        $this->verify = new Resources\Verify($this->httpClient);
        $this->balance = new Resources\Balance($this->httpClient);
        $this->emailmessages = new Resources\EmailMessage($this->httpClient);
        $this->voicemessages = new Resources\VoiceMessage($this->httpClient);
        $this->lookup = new Resources\Lookup($this->httpClient);
        $this->lookupHlr = new Resources\LookupHlr($this->httpClient);
        $this->chatMessages = new Resources\Chat\Message($this->chatAPIHttpClient);
        $this->chatChannels = new Resources\Chat\Channel($this->chatAPIHttpClient);
        $this->chatPlatforms = new Resources\Chat\Platform($this->chatAPIHttpClient);
        $this->chatContacts = new Resources\Chat\Contact($this->chatAPIHttpClient);
        $this->voiceCallFlows = new Resources\Voice\CallFlows($this->voiceAPIHttpClient);
        $this->voiceCalls = new Resources\Voice\Calls($this->voiceAPIHttpClient);
        $this->voiceLegs = new Resources\Voice\Legs($this->voiceAPIHttpClient);
        $this->voiceRecordings = new Resources\Voice\Recordings($this->voiceAPIHttpClient);
        $this->voiceTranscriptions = new Resources\Voice\Transcriptions($this->voiceAPIHttpClient);
        $this->voiceWebhooks = new Resources\Voice\Webhooks($this->voiceAPIHttpClient);
        $this->mmsMessages = new Resources\MmsMessages($this->httpClient);
        $this->contacts = new Resources\Contacts($this->httpClient);
        $this->groups = new Resources\Groups($this->httpClient);
        $this->conversations = new Resources\Conversation\Conversations($this->conversationsAPIHttpClient);
        $this->conversationMessages = new Resources\Conversation\Messages($this->conversationsAPIHttpClient);
        $this->conversationSend = new Resources\Conversation\Send($this->conversationsAPIHttpClient);
        $this->conversationWebhooks = new Resources\Conversation\Webhooks($this->conversationsAPIHttpClient);
        $this->partnerAccounts = new Resources\PartnerAccount\Accounts($this->partnerAccountClient);
        $this->phoneNumbers = new Resources\PhoneNumbers($this->numbersAPIClient);
        $this->availablePhoneNumbers = new Resources\AvailablePhoneNumbers($this->numbersAPIClient);
    }

    /**
     * @param mixed $accessKey
     *
     * @return void
     */
    public function setAccessKey($accessKey): void
    {
        $authentication = new Common\Authentication($accessKey);

        $this->chatAPIHttpClient->setAuthentication($authentication);
        $this->conversationsAPIHttpClient->setAuthentication($authentication);
        $this->httpClient->setAuthentication($authentication);
        $this->voiceAPIHttpClient->setAuthentication($authentication);
        $this->partnerAccountClient->setAuthentication($authentication);
        $this->numbersAPIClient->setAuthentication($authentication);
    }

    /**
     * @return string
     */
    private function getPhpVersion()
    {
        if (!defined('PHP_VERSION_ID')) {
            $version = array_map('intval', explode('.', PHP_VERSION));
            define('PHP_VERSION_ID', $version[0] * 10000 + $version[1] * 100 + $version[2]);
        }

        return 'PHP/' . PHP_VERSION_ID;
    }
}
