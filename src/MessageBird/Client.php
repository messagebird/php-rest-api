<?php

namespace MessageBird;

use GuzzleHttp\ClientInterface;

/**
 * Class Client
 *
 * @package MessageBird
 */
class Client
{
    public const RESTAPI_ENDPOINT = 'https://rest.messagebird.com';
    public const CONVERSATIONSAPI_ENDPOINT = 'https://conversations.messagebird.com/v1';
    public const VOICEAPI_ENDPOINT = 'https://voice.messagebird.com';
    public const PARTNER_ACCOUNT_ENDPOINT = 'https://partner-accounts.messagebird.com';
    public const NUMBERSAPI_ENDPOINT = 'https://numbers.messagebird.com/v1';

    const CLIENT_VERSION = '3.1.2';

    public const TIMEOUT_DEFAULT = 10;

    public const CONNECTION_TIMEOUT_DEFAULT = 2;

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
     * @var ClientInterface
     */
    protected $restClient;

    /**
     * @var ClientInterface
     */
    protected $conversationsClient;

    /**
     * @var ClientInterface
     */
    protected $voiceClient;

    /**
     * @var ClientInterface
     */
    protected $partnerAccountClient;

    /**
     * @var ClientInterface
     */
    protected $numbersClient;

    /**
     * @param string $accessKey
     * @param ClientInterface|null $client
     */
    public function __construct(string $accessKey, ClientInterface $client = null)
    {
        if ($client === null) {
            $this->conversationsClient = new \GuzzleHttp\Client($this->prepareConfig(self::CONVERSATIONSAPI_ENDPOINT, $accessKey));
            $this->restClient = new \GuzzleHttp\Client($this->prepareConfig(self::RESTAPI_ENDPOINT, $accessKey));
            $this->voiceClient = new \GuzzleHttp\Client($this->prepareConfig(self::VOICEAPI_ENDPOINT, $accessKey));
            $this->partnerAccountClient = new \GuzzleHttp\Client($this->prepareConfig(self::PARTNER_ACCOUNT_ENDPOINT, $accessKey));
            $this->numbersClient = new \GuzzleHttp\Client($this->prepareConfig(self::NUMBERSAPI_ENDPOINT, $accessKey));
        } else {
            $this->conversationsClient = $client;
            $this->restClient = $client;
            $this->voiceClient = $client;
            $this->partnerAccountClient = $client;
            $this->numbersClient = $client;
        }

        $this->messages = new Resources\Messages($this->restClient);
        $this->hlr = new Resources\Hlr($this->restClient);
        $this->verify = new Resources\Verify($this->restClient);
        $this->balance = new Resources\Balance($this->restClient);
        $this->emailmessages = new Resources\EmailMessage($this->restClient);
        $this->voicemessages = new Resources\VoiceMessage($this->restClient);
        $this->lookup = new Resources\Lookup($this->restClient);
        $this->lookupHlr = new Resources\LookupHlr($this->restClient);
        $this->voiceCallFlows = new Resources\Voice\CallFlows($this->voiceClient);
        $this->voiceCalls = new Resources\Voice\Calls($this->voiceClient);
        $this->voiceLegs = new Resources\Voice\Legs($this->voiceClient);
        $this->voiceRecordings = new Resources\Voice\Recordings($this->voiceClient);
        $this->voiceTranscriptions = new Resources\Voice\Transcriptions($this->voiceClient);
        $this->voiceWebhooks = new Resources\Voice\Webhooks($this->voiceClient);
        $this->mmsMessages = new Resources\MmsMessages($this->restClient);
        $this->contacts = new Resources\Contacts($this->restClient);
        $this->groups = new Resources\Groups($this->restClient);
        $this->conversations = new Resources\Conversation\Conversations($this->conversationsClient);
        $this->conversationMessages = new Resources\Conversation\Messages($this->conversationsClient);
        $this->conversationSend = new Resources\Conversation\Send($this->conversationsClient);
        $this->conversationWebhooks = new Resources\Conversation\Webhooks($this->conversationsClient);
        $this->partnerAccounts = new Resources\PartnerAccount\Accounts($this->partnerAccountClient);
        $this->phoneNumbers = new Resources\PhoneNumbers($this->numbersClient);
        $this->availablePhoneNumbers = new Resources\AvailablePhoneNumbers($this->numbersClient);
    }

    /**
     * @param string $endpoint
     * @param string $accessKey
     * @return array
     */
    private function prepareConfig(string $endpoint, string $accessKey): array
    {
        return [
            'base_uri' => $endpoint,
            'headers' => [
                'User-Agent' => 'MessageBird/ApiClient/' . self::CLIENT_VERSION . ' ' . $this->getPhpVersion(),
                'Authorization' => 'AccessKey ' . $accessKey,
            ],
            'timeout' => self::TIMEOUT_DEFAULT,
            'connect_timeout' => self::CONNECTION_TIMEOUT_DEFAULT,
            'verify' => dirname(__DIR__) . '/ca-bundle.crt',
        ];
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
}
