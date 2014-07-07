<?php

namespace MessageBird\Objects;

/**
 * Class Hlr
 *
 * @package MessageBird\Objects
 */
class Hlr extends Base
{
    const STATUS_SENT = 'sent';
    const STATUS_ABSENT = 'absent';
    const STATUS_ACTIVE = 'active';
    const STATUS_UNKNOWN = 'unknown';
    const STATUS_FAILED = 'failed';

    protected $id;

    public $msisdn;
    public $network;
    public $reference;
    public $status;

    protected $createdDatetime;
    protected $statusDatetime;
}