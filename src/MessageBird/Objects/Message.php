<?php

namespace MessageBird\Objects;

/**
 * Class Message
 *
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
     * An unique random ID which is created on the MessageBird
     * platform and is returned upon creation of the object.
     *
     * @var string
     */
    protected $id;

    /**
     * The URL of the created object.
     *
     * @var string
     */
    protected $href;

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
     * A hash with extra information. Is only used when a binary or premium
     * message is sent.
     *
     * @var array
     */
    public $typeDetails = array ();

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
    public $recipients = array ();


    /**
     * Send a premium SMS
     *
     * @param $shortcode
     * @param $keyword
     * @param $tariff
     * @param $mid
     */
    public function setPremiumSms($shortcode, $keyword, $tariff, $mid)
    {
        $this->typeDetails['shortcode'] = $shortcode;
        $this->typeDetails['keyword']   = $keyword;
        $this->typeDetails['tariff']    = $tariff;
        $this->typeDetails['mid']       = $mid;

        $this->type = self::TYPE_PREMIUM;
    }

    /**
     * @param $header
     * @param $body
     */
    public function setBinarySms($header, $body)
    {
        $this->typeDetails['udh'] = $header;
        $this->body               = $body;
        $this->type               = self::TYPE_BINARY;
    }

    /**
     * @param $bool
     */
    public function setFlash($bool)
    {
        if ($bool === true) {
            $this->mclass = 0;
        } else {
            $this->mclass = 1;
        }
    }

    /**
     * Get the created id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the CreationDatetime (as a pass by value enforced through the string concatination)
     * 
     * @return string
     * @author Lawri van Buël
     */
    public function getCreationDatetime()
    {
        return $this->createdDatetime . "";
    }    

    /**
     * @param $object
     *
     * @return $this|void
     */
    public function loadFromArray ($object)
    {
        parent::loadFromArray($object);

        if (!empty($this->recipients->items)) {
            foreach($this->recipients->items AS &$item) {
                $Recipient = new Recipient();
                $Recipient->loadFromArray($item);

                $item = $Recipient;
            }
        }

        return $this;
    }
}
