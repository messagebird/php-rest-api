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

    public function getId(): string
    {
        return $this->id;
    }

    public function getRecordingId(): string
    {
        return $this->recordingId;
    }

    public function getError(): string
    {
        return $this->error;
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
