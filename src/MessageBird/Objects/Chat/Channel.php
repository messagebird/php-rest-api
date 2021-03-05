<?php

namespace MessageBird\Objects\Chat;

use MessageBird\Objects\Base;

/**
 * Class Channel
 *
 * @package MessageBird\Objects\Chat
 */
class Channel extends Base
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
     * @var string
     */
    protected $deletedAt;

    /**
     * @var array
     */
    protected $_links = [];

}
