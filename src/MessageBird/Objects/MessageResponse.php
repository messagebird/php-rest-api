<?php

namespace MessageBird\Objects;

/**
 * Class Message
 *
 * @property int $protocolId
 * @package MessageBird\Objects
 */
class MessageResponse extends Base
{
    /**
     * An unique random ID which is created on the MessageBird
     * platform and is returned upon creation of the object.
     *
     * @var string
     */
    public $id;

    /**
     * The URL of the created object.
     *
     * @var string
     */
    public $href;

    /**
     * Tells you if the message is sent or received.
     * mt: mobile terminated (sent to mobile)
     * mo: mobile originated (received from mobile)
     *
     * @var string
     */
    public $direction;

    /**
     * The type of message. Values can be: sms, binary, premium, or flash
     *
     * @var string
     */
    public $type;

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
    public $datacoding;

    /**
     * Indicates the message type. 1 is a normal message, 0 is a flash message.
     *
     * @var int
     */
    public $mclass = 1;

    /**
     * The scheduled date and time of the message in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string|null
     */
    public $scheduledDatetime;

    /**
     * The date and time of the creation of the message in RFC3339 format (Y-m-d\TH:i:sP)
     * @var string
     */
    public $createdDatetime;

    /**
     * An array of recipients
     *
     * @var Recipients
     */
    public $recipients;

    /**
     * @param mixed $object
     *
     * @return $this
     */
    public function loadFromArray($object)
    {
        parent::loadFromArray($object);

        $this->recipients = (new Recipients())->loadFromArray($this->recipients);
        $this->typeDetails = get_object_vars($this->typeDetails);

        return $this;
    }
}
