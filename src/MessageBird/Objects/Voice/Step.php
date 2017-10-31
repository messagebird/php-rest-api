<?php

namespace MessageBird\Objects\Voice;

use MessageBird\Objects\Base;

class Step extends Base
{
    /**
     * The unique (within the call flow) identifier of the step.
     *
     * @var string
     */
    protected $id;

    /**
     * The name of the VoIP action
     *
     * Possible values: transfer, say, play, pause, record, fetchCallFlow, hangup.
     *
     * @var string
     */
    public $action;

    /**
     * Contains zero or more key-value pairs, where the key is the identifier of the option and value is the option
     * value.
     *
     * @var array
     */
    public $options;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}
