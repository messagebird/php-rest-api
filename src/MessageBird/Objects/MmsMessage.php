<?php

namespace MessageBird\Objects;

/**
 * Class MmsMessage
 *
 * @package MessageBird\Objects
 */
class MmsMessage extends Base {

    /**
     * An unique random ID which is created on the MessageBird
     * platform and is returned upon creation of the object.
     *
     * @var string
     */
    protected $id;

    /**
     * The url of the created object.
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
     * The sender of the MMS message. This can be a telephone number
     * (including country code) or an alphanumeric string. In case
     * of an alphanumeric string, the maximum length is 11 characters.
     *
     * @var string
     */
    public $originator;

    /**
     * An array of recipients.
     *
     * @var array
     */
    public $recipients = [];

    /**
     * The subject of MMS the message.
     *
     * @var string
     */
    public $subject;

    /**
     * The body of the MMS message.
     *
     * @var string
     */
    public $body;

    /**
     * The array of URL's to the media attachments that you want to
     * send as part of the MMS message.
     *
     * @var array
     */
    public $mediaUrls = [];

    /**
     * A client reference.
     *
     * @var string
     */
    public $reference;

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
    public $createdDatetime;


    /**
     * Get the created id
     *
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get the created href
     *
     * @return string
     */
    public function getHref() {
        return $this->href;
    }

    /**
     * Get the $createdDatetime value
     *
     * @return string
     */
    public function getCreatedDatetime() {
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
            foreach($this->recipients->items as &$item) {
                $recipient = new Recipient();
                $recipient->loadFromArray($item);

                $item = $recipient;
            }
        }

        return $this;
    }
}
