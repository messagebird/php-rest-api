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
     * Get the created id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
}
