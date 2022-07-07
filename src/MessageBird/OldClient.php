<?php

namespace MessageBird;

use MessageBird\Common\HttpClient;

/**
 * Class Client
 *
 * @package MessageBird
 */
class OldClient
{
    public const ENDPOINT = 'https://rest.messagebird.com';
    public const CONVERSATIONSAPI_ENDPOINT = 'https://conversations.messagebird.com/v1';
    public const VOICEAPI_ENDPOINT = 'https://voice.messagebird.com';
    public const PARTNER_ACCOUNT_ENDPOINT = 'https://partner-accounts.messagebird.com';
    public const NUMBERSAPI_ENDPOINT = 'https://numbers.messagebird.com/v1';

    const CLIENT_VERSION = '3.1.2';

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
     * @var string
     */
    protected $endpoint = self::ENDPOINT;
    /**
     * @var Common\HttpClient
     */
    protected $httpClient;

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
     * @var HttpClient
     */
    protected $numbersAPIClient;

    /**
     * @param string|null $accessKey
     * @param HttpClient|null $httpClient
     */
    public function __construct(?string $accessKey = null, Common\HttpClient $httpClient = null)
    {
        $headers = [
            'User-Agent' => 'MessageBird/ApiClient/' . self::CLIENT_VERSION . ' ' . $this->getPhpVersion()
        ];

        if ($httpClient === null) {
            $this->conversationsAPIHttpClient = new HttpClient(self::CONVERSATIONSAPI_ENDPOINT, $headers);
            $this->httpClient = new HttpClient(self::ENDPOINT, $headers);
            $this->voiceAPIHttpClient = new Common\HttpClient(self::VOICEAPI_ENDPOINT, $headers);
            $this->partnerAccountClient = new Common\HttpClient(self::PARTNER_ACCOUNT_ENDPOINT, $headers);
            $this->numbersAPIClient = new Common\HttpClient(self::NUMBERSAPI_ENDPOINT, $headers);
        } else {
            $this->conversationsAPIHttpClient = $httpClient;
            $this->httpClient = $httpClient;
            $this->voiceAPIHttpClient = $httpClient;
            $this->partnerAccountClient = $httpClient;
            $this->numbersAPIClient = $httpClient;
        }

        if ($accessKey !== null) {
            $this->applyAccessKey($accessKey);
        }

        $this->messages = new Resources\Messages($this->httpClient);
        $this->hlr = new Resources\Hlr($this->httpClient);
        $this->verify = new Resources\Verify($this->httpClient);
        $this->balance = new Resources\Balance($this->httpClient);
        $this->emailmessages = new Resources\EmailMessage($this->httpClient);
        $this->voicemessages = new Resources\VoiceMessage($this->httpClient);
        $this->lookup = new Resources\Lookup($this->httpClient);
        $this->lookupHlr = new Resources\LookupHlr($this->httpClient);
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
     * @return string
     */
    private function getPhpVersion(): string
    {
        if (!\defined('PHP_VERSION_ID')) {
            $version = array_map('intval', explode('.', \PHP_VERSION));
            \define('PHP_VERSION_ID', $version[0] * 10000 + $version[1] * 100 + $version[2]);
        }

        return 'PHP/' . \PHP_VERSION_ID;
    }

    /**
     * @param string $accessKey
     */
    public function applyAccessKey(string $accessKey): void
    {
        $authentication = new Common\Authentication($accessKey);

        $this->conversationsAPIHttpClient->setAuthentication($authentication);
        $this->httpClient->setAuthentication($authentication);
        $this->voiceAPIHttpClient->setAuthentication($authentication);
        $this->partnerAccountClient->setAuthentication($authentication);
        $this->numbersAPIClient->setAuthentication($authentication);
    }
}
