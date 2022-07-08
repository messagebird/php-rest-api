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
     * @var int|null
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
    public $id;
    /**
     * The URL of the created object.
     *
     * @var string
     */
    public $href;
    /**
     * The date and time of the creation of the hlr in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    public $createdDatetime;

    /**
     * The datum time of the last status in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    public $statusDatetime;
}
