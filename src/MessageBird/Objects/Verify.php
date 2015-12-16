<?php

namespace MessageBird\Objects;

/**
 * Class Verify
 *
 * @package MessageBird\Objects
 */
class Verify extends Base
{
    const STATUS_SENT = 'sent';
    const STATUS_VERIFIED = 'verified';
    const STATUS_FAILED = 'failed';
    const STATUS_EXPIRED = 'expired';
    const STATUS_DELETED = 'deleted';

    /**
     * An unique random ID which is created on the MessageBird platform and is returned upon
     * creation of the object.
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
     * The msisdn of the recipient
     *
     * @var int
     */
    public $recipient;

    /**
     * A client reference. Here you can put your own reference,
     * like your internal reference.
     *
     * @var string
     */
    public $reference;

    /**
     * An associative array containing one href entry referring to the URL of the created object.
     * The entry can either refer to either the messages or the voicemessages endpoint
     *
     * @var object
     */
    protected $messages;

    /**
     * The status of the Verify. Possible values: sent, expired, failed, verified, and deleted
     *
     * @var string
     */
    protected $status;

    /**
     * The date and time of the creation of the hlr in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    protected $createdDatetime;

    /**
     * The date and time indicating the expiration time of the verify object in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    protected $validUntilDatetime;


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
     * Get the created href
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->messages->href;
    }

    /**
     * Get the status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
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
     * Get the $validUntilDatetime value
     *
     * @return string
     */
    public function getValidUntilDatetime()
    {
        return $this->validUntilDatetime;
    }
}
