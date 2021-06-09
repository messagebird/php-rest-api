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

    public function getId(): string
    {
        return $this->id;
    }

    public function getCallId(): string
    {
        return $this->callId;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getDestination(): string
    {
        return $this->destination;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function getDirection(): string
    {
        return $this->direction;
    }

    public function getCreatedAt(): string
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function getAnsweredAt(): string
    {
        return $this->answeredAt;
    }

    public function getEndedAt(): string
    {
        return $this->endedAt;
    }
}
