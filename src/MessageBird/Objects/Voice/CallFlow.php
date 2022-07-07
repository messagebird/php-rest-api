<?php

namespace MessageBird\Objects\Voice;

use MessageBird\Objects\Base;

/**
 *
 */
class CallFlow extends Base
{
    /**
     * An array of step objects.
     *
     * The sequence of the array items describe the order of execution, where the first item will be executed first,
     * than the second, etcetera.
     *
     * @var Step[]
     */
    public $steps;
    /**
     * The unique ID of the call
     *
     * @var string
     */
    protected $id;
    /**
     * The date and time the call flow was created
     *
     * @var string
     */
    protected $createdAt;

    /**
     * The date and time the call flow was last updated
     *
     * @var string
     */
    protected $updatedAt;


    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
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
}
