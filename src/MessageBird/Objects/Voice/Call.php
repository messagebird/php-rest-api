<?php

namespace MessageBird\Objects\Voice;

use MessageBird\Objects\Base;

/**
 *
 */
class Call extends Base
{
    /**
     * The caller ID of the call
     *
     * @var string
     */
    public $source;
    /**
     * The number/address to be called.
     *
     * @var string
     */
    public $destination;
    /**
     * The call flow object to be executed when the call is answered.
     *
     * @var CallFlow
     */
    public $callFlow;
    /**
     * The unique ID of the call
     *
     * @var string
     */
    public $id;
    /**
     * The unique ID of the number that is/was called
     *
     * @var string
     */
    public $numberId;

    /**
     * The status of the call. Possible values: starting, ongoing, ended.
     *
     * @var string
     */
    public $status;

    /**
     * The date and time the call was created
     *
     * @var string
     */
    public $createdAt;

    /**
     * The date and time the call was last updated
     *
     * @var string
     */
    public $updatedAt;

    /**
     * The date and time the call ended
     *
     * @var string
     */
    public $endedAt;

    /**
     * @var array
     */
    public $webhook;

    /**
     * @var array
     */
    public $_links;
}
