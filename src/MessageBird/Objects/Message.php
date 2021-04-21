<?php

namespace MessageBird\Objects;

/**
 * Class Message
 *
 * @property int $protocolId
 * @package MessageBird\Objects
 */
class Message extends Base
{
    const TYPE_SMS = 'sms';
    const TYPE_BINARY = 'binary';
    const TYPE_PREMIUM = 'premium';

    const DATACODING_UNICODE = 'unicode';
    const DATACODING_PLAIN = 'plain';

    /**
     * Tells you if the message is sent or received.
     * mt: mobile terminated (sent to mobile)
     * mo: mobile originated (received from mobile)
     *
     * @var string
     */
    public $direction = 'mt';

    /**
     * The type of message. Values can be: sms, binary, premium, or flash
     *
     * @var string
     */
    public $type = self::TYPE_SMS;

    /**
     * The sender of the message. This can be a telephone number
     * (including country code) or an alphanumeric string. In case
     * of an alphanumeric string, the maximum length is 11 characters.
     *
     * @var string
     */
    public $originator;

    /**
     * The body of the SMS message.
     *
     * @var string
     */
    public $body;

    /**
     * A client reference. Here you can put your own reference,
     * like your internal reference.
     *
     * @var string
     */
    public $reference;

    /**
     * The amount of seconds that the message is valid.
     * If a message is not delivered within this time,
     * the message will be discarded.
     *
     * @var int
     */
    public $validity;

    /**
     * The SMS route that is used to send the message. This is for
     * advanced users.
     *
     * @var int
     */
    public $gateway;

    /**
     * An associative array with extra information. Is only used when a binary or premium
     * message is sent.
     *
     * @var array
     */
    public $typeDetails =  [];

    /**
     * The datacoding used, can be plain or unicode
     *
     * @var string
     */
    public $datacoding = self::DATACODING_PLAIN;

    /**
     * Indicates the message type. 1 is a normal message, 0 is a flash message.
     *
     * @var int
     */
    public $mclass = 1;

    /**
     * The scheduled date and time of the message in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    public $scheduledDatetime;

    /**
     * The date and time of the creation of the message in RFC3339 format (Y-m-d\TH:i:sP)
     * @var string
     */
    protected $createdDatetime;

    /**
     * An array of recipients
     *
     * @var array
     */
    public $recipients =  [];

    /**
     * The URL to send status delivery reports for the message to
     *
     * @var string
     */
    public $reportUrl;


    /**
     * Send a premium SMS
     *
     * @param mixed $shortcode
     * @param mixed $keyword
     * @param mixed $tariff
     * @param mixed $mid
     * @param mixed $member
     *
     * @return void
     */
    public function setPremiumSms($shortcode, $keyword, $tariff, $mid = null, $member = null): void
    {
        $this->typeDetails['shortcode'] = $shortcode;
        $this->typeDetails['keyword']   = $keyword;
        $this->typeDetails['tariff']    = $tariff;
        if ($mid !== null) {
            $this->typeDetails['mid'] = $mid;
        }
        if ($member !== null) {
            $this->typeDetails['member'] = $member;
        }

        $this->type = self::TYPE_PREMIUM;
    }

    /**
     * @param mixed $header
     * @param mixed $body
     *
     * @return void
     */
    public function setBinarySms($header, $body): void
    {
        $this->typeDetails['udh'] = $header;
        $this->body               = $body;
        $this->type               = self::TYPE_BINARY;
    }

    /**
     * @param mixed $bool
     *
     * @return void
     */
    public function setFlash($bool): void
    {
        if ($bool === true) {
            $this->mclass = 0;
        } else {
            $this->mclass = 1;
        }
    }

    /**
     * Get the $createdDatetime value
     *
     * @return string
     */
    public function getCreatedDatetime()
    {
        return $this->createdDatetime;
    }

    /**
     * @param mixed $object
     *
     * @return $this|void
     */
    public function loadFromArray($object)
    {
        parent::loadFromArray($object);

        if (!empty($this->recipients->items)) {
            foreach ($this->recipients->items as &$item) {
                $recipient = new Recipient();
                $recipient->loadFromArray($item);

                $item = $recipient;
            }
        }

        return $this;
    }
}
