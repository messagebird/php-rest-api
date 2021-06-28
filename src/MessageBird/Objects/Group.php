<?php

namespace MessageBird\Objects;

/**
 * Class Group
 *
 * @package MessageBird\Objects
 */
class Group extends Base
{
    /**
     * The name of the group.
     *
     * @var int
     */
    public $name;
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
     * The hash with the contacts in group.
     *
     * @var array
     */
    protected $contacts = [];

    /**
     * The date and time of the creation of the group in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    protected $createdDatetime;

    /**
     * The date and time of the updated of the group in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    protected $updatedDatetime;

    /**
     * Get the created id
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * Get the created href
     */
    public function getHref(): string
    {
        return $this->href;
    }

    /**
     * Get the $createdDatetime value
     */
    public function getCreatedDatetime(): string
    {
        return $this->createdDatetime;
    }

    /**
     * Get the $updatedDatetime value
     */
    public function getUpdatedDatetime(): string
    {
        return $this->createdDatetime;
    }

    /**
     * @param mixed $object
     *
     * @return $this|void
     */
    public function loadFromArray($object)
    {
        parent::loadFromArray($object);

        if (!empty($object->items)) {
            foreach ($object->items as &$item) {
                $contact = new Contact();
                $contact->loadFromArray($item);

                $item = $contact;
            }
        }

        return $object;
    }
}
