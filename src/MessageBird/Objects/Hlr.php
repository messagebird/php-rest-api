<?php

namespace MessageBird\Objects;

/**
 * Class Hlr
 *
 * @package MessageBird\Objects
 */
class Hlr extends Base
{
    public const STATUS_SENT = 'sent';
    public const STATUS_ABSENT = 'absent';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_UNKNOWN = 'unknown';
    public const STATUS_FAILED = 'failed';
    /**
     * The msisdns you want to do a network query on
     *
     * @var int
     */
    public $msisdn;
    /**
     * The MCCMNC code of the network provider. (http://en.wikipedia.org/wiki/Mobile_country_code)
     *
     * @var int
     */
    public $network;
    /**
     * A array with extra HLR information. Do note that the attributes in the array can change over time and
     * can be null (not all information is availble for all countries and providers).
     *
     * @var array
     */
    public $details = [];
    /**
     * A client reference. Here you can put your own reference,
     * like your internal reference.
     *
     * @var string
     */
    public $reference;
    /**
     * The status of the msisdns. Possible values: sent, absent, active, unknown, and failed
     *
     * @var string
     */
    public $status;
    /**
     * An unique random ID which is created on the MessageBird platform and is returned upon creation of the object.
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
     * The date and time of the creation of the hlr in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    protected $createdDatetime;

    /**
     * The datum time of the last status in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    protected $statusDatetime;

    /**
     * Get the created id
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the created href
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * Get the date and time the resource was created
     */
    public function getCreatedDatetime(): string
    {
        return $this->createdDatetime;
    }

    /**
     * Get the date and time the resource was created
     */
    public function getStatusDatetime(): string
    {
        return $this->statusDatetime;
    }
}
