<?php

namespace MessageBird\Objects;

/**
 * Class ChatChannel
 *
 * @package MessageBird\Objects
 */
class ChatChannel extends Base
{

    /**
     * The name of the Channel
     *
     * @var string
     */
    public $name;

    /**
     * The id of a valid Platform to base the Channel on.
     *
     * @var string
     */
    public $platformId;

    /**
     * A hash of values as defined in channel_template of a Platform
     *
     * @var string
     */
    public $channelDetails;

    /**
     * The callback URL used for posting a webhook on message updates
     *
     * @var string
     */
    public $callbackUrl;

    /**
     * The endpoint of the action (platforms, messages, channels, contacts)
     *
     * @var string
     */
    public $endpoint;

    /**
     * A unique random ID which is created on the MessageBird platform and is returned upon creation of the object.
     *
     * @var string
     */
    protected $id;

    /**
     * The status of the Channel. Possible values: registered, active, invalid, deleted
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
     * The date and time the object was deleted
     *
     * @var
     */
    protected $deletedAt;

    /**
     * @var array
     */
    protected $_links = array();

    /**
     * @param $object
     *
     * @return $this|void
     */
    public function loadFromArray ($object)
    {
        parent::loadFromArray($object);

        return $this;
    }

}