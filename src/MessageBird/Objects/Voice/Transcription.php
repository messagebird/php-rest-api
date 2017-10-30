<?php

namespace MessageBird\Objects\Voice;

use MessageBird\Objects\Base;

class Transcription extends Base
{
    /**
     * The unique ID of the transcription
     *
     * @var string
     */
    protected $id;

    /**
     * The ID of the recording that this transcription belongs to
     *
     * @var string
     */
    protected $recordingId;

    /**
     * In case that an error was occurred while executing the transcription request, it appears here
     *
     * @var string
     */
    protected $error;

    /**
     * The date and time the transcription was created
     *
     * @var string
     */
    protected $createdAt;

    /**
     * The date and time the transcription was last updated
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
    public function getRecordingId()
    {
        return $this->recordingId;
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
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
