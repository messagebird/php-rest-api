<?php

namespace MessageBird\Objects\Chat;

use MessageBird\Objects\Base;

/**
 * Class Message
 *
 * @package MessageBird\Objects
 */
class Message extends Base
{

    /**
     * The type of the messages. Possible values: text, image, audio, video, location
     *
     * @var string
     */
    public $type = 'text';

    /**
     * The contents of the message.
     * Required when type is text or location, optional for the other multimedia types.
     *
     * @var string
     */
    public $payload;

    /**
     * The ID of the contact to send the message to.
     *
     * @var string
     */
    public $contactId;

    /**
     * A unique random ID which is created on the MessageBird platform and is returned upon creation of the object.
     *
     * @var string
     */
    protected $id;

    /**
     * The status of the message.
     * Possible values: pending, received, sent, delivered, unsupported, failed and pending_media.
     *
     * @var string
     */
    protected $status;

    /**
     * The date and time the object was created.
     *
     * @var string
     */
    protected $createdAt;

    /**
     * The date and time the object was last updated.
     *
     * @var string
     */
    protected $updatedAt;

    /**
     * The URI of the media file contained in the message. Used when type is one of mage, audio or video.
     *
     * @var string
     */
    protected $mediaPath;

    /**
     * @var array
     */
    protected $_links = [];


    public function getId(): string
    {
        return $this->id;
    }
}
