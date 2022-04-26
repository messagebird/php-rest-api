<?php

namespace MessageBird\Objects\Voice;

use MessageBird\Objects\Base;

class CallFlow extends Base
{
    /**
     * The title of the call flow
     *
     * @var string
     * @deprecated
     */
    public $title;
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

    function __construct() {
        if ($this->title == null) {
            unset($this->title);
        }
    }

    /**
     * @inheritdoc
     */
    public function loadFromArray($object): self
    {
        parent::loadFromArray($object);

        foreach ($this->steps as &$item) {
            $step = new Step();
            $step->loadFromArray($item);

            $item = $step;
        }

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }
}
