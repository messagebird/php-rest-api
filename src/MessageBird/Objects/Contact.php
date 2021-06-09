<?php

namespace MessageBird\Objects;

/**
 * Class Contact
 *
 * @package MessageBird\Objects
 */
class Contact extends Base
{
    /**
     * The phone number of contact.
     *
     * @var int
     */
    public $msisdn;
    /**
     * The first name of the contact.
     *
     * @var string
     */
    public $firstName;
    /**
     * The last name of the contact.
     *
     * @var string
     */
    public $lastName;
    /**
     * @var string
     */
    public $custom1;
    /**
     * @var string
     */
    public $custom2;
    /**
     * @var string
     */
    public $custom3;
    /**
     * @var string
     */
    public $custom4;
    /**
     * An unique random ID which is created on the MessageBird
     * platform and is returned upon creation of the object.
     *
     * @var string
     */
    protected $id;
    /**
     * The URL of the created object.
     *
     * @var string
     */
    protected $href;
    /**
     * Custom fields of the contact.
     *
     * @var array
     */
    protected $customDetails = [];
    /**
     * The hash of the group this contact belongs to.
     *
     * @var array
     */
    protected $groups = [];

    /**
     * The hash with messages sent to contact.
     *
     * @var array
     */
    protected $messages = [];

    /**
     * The date and time of the creation of the contact in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    protected $createdDatetime;

    /**
     * The date and time of the updated of the contact in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    protected $updatedDatetime;

    public function getId(): string
    {
        return $this->id;
    }

    public function getHref(): string
    {
        return $this->href;
    }

    public function getGroups(): array
    {
        return $this->groups;
    }

    public function getMessages(): array
    {
        return $this->messages;
    }

    public function getCreatedDatetime(): string
    {
        return $this->createdDatetime;
    }

    public function getUpdatedDatetime(): string
    {
        return $this->updatedDatetime;
    }

    public function getCustomDetails(): array
    {
        return $this->customDetails;
    }

    /**
     * @param mixed $object
     */
    public function loadFromArray($object): Contact
    {
        unset($this->custom1, $this->custom2, $this->custom3, $this->custom4);

        return parent::loadFromArray($object);
    }

    /**
     * @param mixed $object
     *
     * @return $this ->object
     */
    public function loadFromArrayForGroups($object)
    {
        parent::loadFromArray($object);

        if (!empty($object->items)) {
            foreach ($object->items as &$item) {
                $group = new Group();
                $group->loadFromArray($item);

                $item = $group;
            }
        }
        return $object;
    }
}
