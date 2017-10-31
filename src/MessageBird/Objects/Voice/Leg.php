<?php

namespace MessageBird\Objects\Voice;

use MessageBird\Objects\Base;

class Leg extends Base
{
    /**
     * The unique ID of the leg
     *
     * @var string
     */
    protected $id;

    /**
     * The unique ID of the call that this leg belongs to
     *
     * @var string
     */
    protected $callId;

    /**
     * The number/SIP URL that is making the connection
     *
     * @var string
     */
    protected $source;

    /**
     * The number/SIP URL that a connection is made to
     *
     * @var string
     */
    protected $destination;

    /**
     * The status of the leg. Possible values: ongoing, hangup
     *
     * @var string
     */
    protected $status;

    /**
     * The direction of the leg, indicating if it's an incoming connection or outgoing (e.g. for transfering a call).
     * Possible values: incoming, outgoing.
     *
     * @var string
     */
    protected $direction;

    /**
     * The date and time the leg was created
     *
     * @var string
     */
    protected $createdAt;

    /**
     * The date and time the leg was last updated
     *
     * @var string
     */
    protected $updatedAt;

    /**
     * The date and time the leg was answered at
     *
     * @var string
     */
    protected $answeredAt;

    /**
     * The date and time the leg ended
     *
     * @var string
     */
    protected $endedAt;

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
    public function getCallId()
    {
        return $this->callId;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getDestination()
    {
        return $this->destination;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
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

    /**
     * @return string
     */
    public function getAnsweredAt()
    {
        return $this->answeredAt;
    }

    /**
     * @return string
     */
    public function getEndedAt()
    {
        return $this->endedAt;
    }
}
