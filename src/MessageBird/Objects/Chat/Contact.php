<?php

namespace MessageBird\Objects\Chat;

use MessageBird\Objects\Base;

/**
 * Class Contact
 *
 * @package MessageBird\Objects\Chat
 */
class Contact extends Base
{

    /**
     * A unique random ID which is created on the MessageBird platform and is returned upon creation of the object.
     *
     * @var string
     */
    protected $id;

    /**
     * First name of contact
     *
     * @var string
     */
    public $firstName;

    /**
     * Last name of contact
     *
     * @var string
     */
    public $lastName;

    /**
     * Contact details array
     *
     * @var array
     */
    public $contactDetails = [];

    /**
     * Channel ID.
     *
     * @var string
     */
    protected $channelId;

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
}
