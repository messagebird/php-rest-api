<?php

namespace MessageBird\Objects;

/**
 * Class Verify
 *
 * @package MessageBird\Objects
 */
class Verify extends Base
{
    public const STATUS_SENT = 'sent';
    public const STATUS_VERIFIED = 'verified';
    public const STATUS_FAILED = 'failed';
    public const STATUS_EXPIRED = 'expired';
    public const STATUS_DELETED = 'deleted';
    /**
     * The msisdn or email of the recipient
     *
     * @var string
     */
    public $recipient;
    /**
     * A client reference. Here you can put your own reference,
     * like your internal reference.
     *
     * @var string|null
     */
    public $reference;
    /**
     * An unique random ID which is created on the MessageBird platform and is returned upon
     * creation of the object.
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
     * An associative array containing one href entry referring to the URL of the created object.
     * The entry can either refer to either the messages or the voicemessages endpoint
     *
     * @var array
     */
    public $messages;

    /**
     * The status of the Verify. Possible values: sent, expired, failed, verified, and deleted
     *
     * @var string
     */
    public $status;

    /**
     * The date and time of the creation of the hlr in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    public $createdDatetime;

    /**
     * The date and time indicating the expiration time of the verify object in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    public $validUntilDatetime;
}
