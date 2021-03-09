<?php

namespace MessageBird\Objects\Chat;

use MessageBird\Objects\Base;

/**
 * Class Platform
 *
 * @package MessageBird\Objects\Chat
 */
class Platform extends Base
{

    /**
     * A unique random ID which is created on the MessageBird platform and is returned upon creation of the object.
     *
     * @var string
     */
    protected $id;

    /**
     * The name of the platform.
     *
     * @var string
     */
    protected $name;

    /**
     * A hash with name-value pairs indicating which contact details
     * (and their respective data types) are required when creating a contact for this platform.
     *
     * @var array
     */
    protected $contactTemplate = [];

    /**
     * The name of the channel details parameter that uniquely identifies a channel on this platform.
     *
     * @var string
     */
    protected $channelIdentifier;

    /**
     * 	The name of the contact details parameter that uniquely identifies a contact on this platform.
     *
     * @var string
     */
    protected $contactIdentifier;

    /**
     * A hash with name-value pairs indicating which channel details
     * (and their respective data types) are required when creating a channel for this platform.
     *
     * @var string
     */
    protected $channelTemplate;

    /**
     * The date and time of the creation of the platform in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    protected $createdAt;
    /**
     * The date and time of platform's update in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    protected $updatedAt;

    /**
     * @var array
     */
    protected $_links;
}
