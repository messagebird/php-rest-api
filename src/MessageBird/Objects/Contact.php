<?php

namespace MessageBird\Objects;

use stdClass;

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
     * @var stdClass
     */
    protected $customDetails = [];
    /**
     * The hash of the group this contact belongs to.
     *
     * @var ?stdClass
     */
    protected $groups = null;

    /**
     * The hash with messages sent to contact.
     *
     * @var ?stdClass
     */
    protected $messages = null;

    /**
     * The date and time of the creation of the contact in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    protected $createdDatetime;

    /**
     * The date and time of the updated of the contact in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string|null
     */
    protected $updatedDatetime;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * @return stdClass
     */
    public function getGroups(): stdClass
    {
        return $this->groups;
    }

    /**
     * @return stdClass
     */
    public function getMessages(): stdClass
    {
        return $this->messages;
    }

    /**
     * @return string
     */
    public function getCreatedDatetime(): string
    {
        return $this->createdDatetime;
    }

    /**
     * @return string|null
     */
    public function getUpdatedDatetime(): ?string
    {
        return $this->updatedDatetime;
    }

    /**
     * @return stdClass
     */
    public function getCustomDetails(): stdClass
    {
        return $this->customDetails;
    }

    /**
     * @param stdClass $object
     * @return $this
     */
    public function loadFromStdclass(stdClass $object): self
    {
        unset($this->custom1, $this->custom2, $this->custom3, $this->custom4);

        return parent::loadFromStdclass($object);
    }

    /**
     * @param stdClass $object
     * @return stdClass
     */
    public function loadFromStdclassForGroups(stdClass $object): stdClass
    {
        parent::loadFromStdclass($object);

        if (!empty($object->items)) {
            foreach ($object->items as &$item) {
                $group = new Group();
                $group->loadFromStdclass($item);

                $item = $group;
            }
        }
        return $object;
    }
}
