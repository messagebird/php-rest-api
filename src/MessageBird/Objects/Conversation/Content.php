<?php

namespace MessageBird\Objects\Conversation;

use JsonSerializable;
use MessageBird\Objects\Base;
use MessageBird\Objects\Conversation\HSM\Message as HSMMessage;
use stdClass;

/**
 * Represents a Message object's actual content. Formatted depending on type.
 */
class Content extends Base implements JsonSerializable
{
    public const TYPE_AUDIO = 'audio';
    public const TYPE_FILE = 'file';
    public const TYPE_IMAGE = 'image';
    public const TYPE_LOCATION = 'location';
    public const TYPE_TEXT = 'text';
    public const TYPE_VIDEO = 'video';
    public const TYPE_HSM = 'hsm';

    /**
     * @var string[]
     */
    public $audio;

    /**
     * @var string[]
     */
    public $file;

    /**
     * @var string[]
     */
    public $image;

    /**
     * @var float[]
     */
    public $location;

    /**
     * @var string
     */
    public $text;

    /**
     * @var string[]
     */
    public $video;

    /**
     * @var HSMMessage
     */
    public $hsm;

    /**
     * @deprecated 2.2.0 No longer used by internal code, please switch to {@see self::loadFromStdclass()}
     * 
     * @param mixed $object
     *
     * @return $this
     */
    public function loadFromArray($object): self
    {
        // Text is already properly set if available due to the response's structure.
        parent::loadFromArray($object);

        $this->loadLocationIfNeeded();
        $this->loadMediaIfNeeded();

        return $this;
    }

    public function loadFromStdclass(stdClass $object): self
    {
        // Text is already properly set if available due to the response's structure.
        parent::loadFromStdclass($object);

        $this->loadLocationIfNeeded();
        $this->loadMediaIfNeeded();

        return $this;
    }

    /**
     * Sets the location on this object if available.
     */
    private function loadLocationIfNeeded(): void
    {
        if (empty($this->location->latitude)) {
            return;
        }
        if (empty($this->location->longitude)) {
            return;
        }
        $this->location = [
            'latitude' => $this->location->latitude,
            'longitude' => $this->location->longitude,
        ];
    }

    /**
     * Sets the media on this object if available.
     */
    private function loadMediaIfNeeded(): void
    {
        if (!empty($this->audio->url)) {
            $this->audio = ['url' => $this->audio->url];
        }

        if (!empty($this->file->url)) {
            $this->file = ['url' => $this->file->url];
        }

        if (!empty($this->image->url)) {
            $this->image = ['url' => $this->image->url];
        }

        if (!empty($this->video->url)) {
            $this->video = ['url' => $this->video->url];
        }
    }

    /**
     * Serialize only non empty fields.
     */
    public function jsonSerialize(): array
    {
        $json = [];

        foreach (get_object_vars($this) as $key => $value) {
            if (!empty($value)) {
                $json[$key] = $value;
            }
        }

        return $json;
    }
}
