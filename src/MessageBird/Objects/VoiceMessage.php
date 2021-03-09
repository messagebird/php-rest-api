<?php

namespace MessageBird\Objects;

/**
 * Class VoiceMessage
 *
 * @package MessageBird\Objects
 */
class VoiceMessage extends Base
{
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
     * The originator of the voice message.
     *
     * Should be a valid MSISDN (telephone number including country code)
     * @var string/int
     */
    public $originator;

    /**
     * The body of the voice message.
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
     * The language in which the message needs to be read to the recipient.
     * Possible values are: nl-nl, de-de, en-gb, en-us, fr-fr
     *
     * @var string
     */
    public $language = 'en-gb';

    /**
     * The voice in which the messages needs to be read to the recipient
     * Possible values are: male, female
     *
     * @var string
     */
    public $voice = 'female';

    /**
     * How many times needs the message to be repeated?
     *
     * @var int
     */
    public $repeat = 1;

    /**
     * What to do when a machine picks up the phone?
     * Possible values are:
     *  - continue: do not check, just play the message
     *  - delay: if a machine answers, wait until the machine stops talking
     *  - hangup: hangup when a machine answers
     *
     * @var string
     */
    public $ifMachine = 'continue';

    /**
     * The time (in milliseconds) to analyze if a machine has picked up the phone. Used in combination with the delay
     * and hangup values of the ifMachine attribute. Minimum: 400, maximum: 10000.
     *
     * @var int
     */
    public $machineTimeout = 7000;

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
     * The URL to send status delivery reports for the voice message to
     *
     * @var string
     */
    public $reportUrl;

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
     * Get the created href
     *
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * Get the date and time the resource was created
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
    public function loadFromArray ($object)
    {
        parent::loadFromArray($object);

        if (!empty($this->recipients->items)) {
            foreach($this->recipients->items AS &$item) {
                $recipient = new Recipient();
                $recipient->loadFromArray($item);

                $item = $recipient;
            }
        }

        return $this;
    }
}
