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
    protected $id;
    /**
     * The unique ID of the number that is/was called
     *
     * @var string
     */
    protected $numberId;

    /**
     * The status of the call. Possible values: starting, ongoing, ended.
     *
     * @var string
     */
    protected $status;

    /**
     * The date and time the call was created
     *
     * @var string
     */
    protected $createdAt;

    /**
     * The date and time the call was last updated
     *
     * @var string
     */
    protected $updatedAt;

    /**
     * The date and time the call ended
     *
     * @var string
     */
    protected $endedAt;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getNumberId(): string
    {
        return $this->numberId;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    /**
     * @return string
     */
    public function getEndedAt(): string
    {
        return $this->endedAt;
    }
}
