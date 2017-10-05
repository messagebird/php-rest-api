<?php

namespace MessageBird\Objects\Voice;

use MessageBird\Objects\Base;

class Call extends Base
{
    /**
     * The unique ID of the call
     *
     * @var string
     */
    protected $id;

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
     * @inheritdoc
     */
    public function loadFromArray($object)
    {
        parent::loadFromArray($object);

        if (!empty($this->callFlow)) {
            $callFlow = new CallFlow();
            $this->callFlow = $callFlow->loadFromArray($this->callFlow);
        }

        return $this;
    }
}
