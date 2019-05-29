<?php

namespace MessageBird\Objects\Conversation;

use JsonSerializable;
use MessageBird\Objects\Base;
use MessageBird\Objects\Conversation\HSM\Message as HSMMessage;

/**
 * Represents a Message object's actual content. Formatted depending on type.
 */
class Content extends Base implements JsonSerializable
{
    const TYPE_AUDIO = 'audio';
    const TYPE_FILE = 'file';
    const TYPE_IMAGE = 'image';
    const TYPE_LOCATION = 'location';
    const TYPE_TEXT = 'text';
    const TYPE_VIDEO = 'video';
    const TYPE_HSM = 'hsm';

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
     * @param $object
     *
     * @return $this
     */
    public function loadFromArray($object)
    {
        // Text is already properly set if available due to the response's structure.
        parent::loadFromArray($object);
        
        $this->loadLocationIfNeeded();
        $this->loadMediaIfNeeded();

        return $this;
    }

    /**
     * Sets the location on this object if available.
     */
    private function loadLocationIfNeeded()
    {
        if (!empty($this->location->latitude) && !empty($this->location->longitude)) {
            $this->location = array(
                'latitude' => $this->location->latitude,
                'longitude' => $this->location->longitude,
            );
        }
    }

    /**
     * Sets the media on this object if available.
     */
    private function loadMediaIfNeeded()
    {
        if (!empty($this->audio->url)) {
            $this->audio = array('url' => $this->audio->url);
        }

        if (!empty($this->file->url)) {
            $this->file = array('url' => $this->file->url);
        }

        if (!empty($this->image->url)) {
            $this->image = array('url' => $this->image->url);
        }

        if (!empty($this->video->url)) {
            $this->video = array('url' => $this->video->url);
        }
    }

    /**
     * Serialize only non empty fields.
     */
    public function jsonSerialize()
    {
        $json = array();
        
        foreach (get_object_vars($this) as $key => $value) {
            if (!empty($value)) {
                $json[$key] = $value;
            }
        }

        return $json;
    }
}
