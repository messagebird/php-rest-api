<?php

namespace MessageBird\Objects\Conversation;

use MessageBird\Objects\Base;

/**
 * Represents a Message object's actual content. Formatted depending on type.
 */
class Content extends Base
{
    const TYPE_AUDIO = 'audio';
    const TYPE_FILE = 'file';
    const TYPE_HSM = 'hsm';
    const TYPE_IMAGE = 'image';
    const TYPE_LOCATION = 'location';
    const TYPE_TEXT = 'text';
    const TYPE_VIDEO = 'video';

    /**
     * @var string[]
     */
    public $audio;

    /**
     * @var string[]
     */
    public $file;

    /**
     * @var Hsm
     */
    public $hsm;

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
     * @param $object
     *
     * @return $this
     */
    public function loadFromArray($object)
    {
        // Text is already properly set if available due to the response's structure.
        parent::loadFromArray($object);
        
        $this->loadHsmIfNeeded();
        $this->loadLocationIfNeeded();
        $this->loadMediaIfNeeded();

        return $this;
    }

    /**
     * Sets the HSM on this object if available.
     */
    public function loadHsmIfNeeded()
    {
        if (!empty($this->hsm)) {
            $hsm = new Hsm();
            $hsm->loadFromArray($this->hsm);

            $this->hsm = $hsm;
        }
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
}
