<?php

namespace MessageBird\Objects;

/**
 * Class EmailMessage
 *
 * @package MessageBird\Objects
 */
class EmailMessage extends Base
{
    /**
     * An unique random ID which is created on the MessageBird
     * platform and is returned upon creation of the object.
     *
     * @var string
     */
    protected $id;

    /**
     * The status of the Email Message.
     *
     * @var string
     */
    protected $status;

    /**
     * Failure code in the event that something went wrong
     *
     * @var int|null
     */
    protected $failure_code;

    /**
     * Failure description in the event that something went wrong
     *
     * @var string|null
     */
    protected $failure_description;

    /**
     * Get the created id
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the status
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int|null
     */
    public function getFailureCode()
    {
        return $this->failure_code;
    }

    /**
     * @return string|null
     */
    public function getFailureDescription()
    {
        return $this->failure_description;
    }
}
