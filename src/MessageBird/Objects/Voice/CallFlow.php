<?php

namespace MessageBird\Objects\Voice;

use MessageBird\Objects\Base;

class CallFlow extends Base
{

    /**
     * The unique ID of the call
     *
     * @var string
     */
    protected $id;

    /**
     * The title of the call flow
     *
     * @var string
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
     * @inheritdoc
     */
    public function loadFromArray($object)
    {
        parent::loadFromArray($object);

        if (!empty($this->steps)) {
            foreach ($this->steps as &$item) {
                $step = new Step();
                $step->loadFromArray($item);
                $step->options = (array) $step->options;

                $item = $step;
            }
        }

        return $this;
    }

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
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
