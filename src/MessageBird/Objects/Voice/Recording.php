<?php

namespace MessageBird\Objects\Voice;

use MessageBird\Objects\Base;

class Recording extends Base
{
    /**
     * The unique ID of the recording
     *
     * @var string
     */
    protected $id;

    /**
     * The ID of the leg that this recording belongs to
     *
     * @var string
     */
    protected $legId;

    /**
     * The status of the recording. Possible values: initialised, queued, recording, paused, done, failed, canceled
     *
     * @var string
     */
    protected $status;

    /**
     * The duration of the recording in seconds.
     *
     * @var int
     */
    protected $duration;

    /**
     * The date and time the recording was created
     *
     * @var string
     */
    protected $createdAt;

    /**
     * The date and time the recording was last updated
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
    public function getLegId()
    {
        return $this->legId;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getDuration()
    {
        return $this->duration;
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
