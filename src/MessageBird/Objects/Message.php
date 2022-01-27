<?php

namespace MessageBird\Objects;

use stdClass;

/**
 * Class Message
 *
 * @property int $protocolId
 * @package MessageBird\Objects
 */
class Message extends Base
{
    public const TYPE_SMS = 'sms';
    public const TYPE_BINARY = 'binary';

    public const DATACODING_UNICODE = 'unicode';
    public const DATACODING_PLAIN = 'plain';

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
    public $typeDetails = [];

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
     * An array of recipients
     *
     * @var array
     */
    public $recipients = [];
    /**
     * The URL to send status delivery reports for the message to
     *
     * @var string
     */
    public $reportUrl;
    /**
     * The date and time of the creation of the message in RFC3339 format (Y-m-d\TH:i:sP)
     * @var string
     */
    protected $createdDatetime;

    /**
     * @param mixed $header
     * @param mixed $body
     */
    public function setBinarySms($header, $body): void
    {
        $this->typeDetails['udh'] = $header;
        $this->body = $body;
        $this->type = self::TYPE_BINARY;
    }

    /**
     * @param mixed $bool
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
     *     */
    public function getCreatedDatetime(): string
    {
        return $this->createdDatetime;
    }

    /**
     * @deprecated 2.2.0 No longer used by internal code, please switch to {@see self::loadFromStdclass()}
     * 
     * @param mixed $object
     * 
     * @return self
     */
    public function loadFromArray($object): self
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

    /**
     * @param stdClass $object 
     * @return self 
     */
    public function loadFromStdclass(stdClass $object): self
    {
        parent::loadFromStdclass($object);

        if (!empty($this->recipients->items)) {
            foreach ($this->recipients->items as &$item) {
                $recipient = new Recipient();
                $recipient->loadFromStdclass($item);

                $item = $recipient;
            }
        }

        return $this;
    }
}
