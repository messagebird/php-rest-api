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
     * Custom fields of the contact.
     *
     * @var array
     */
    protected $customDetails = array();

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
     * The hash of the group this contact belongs to.
     *
     * @var array
     */
    protected $groups = array();

    /**
     * The hash with messages sent to contact.
     *
     * @var array
     */
    protected $messages = array();

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

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * @return string
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * @return string
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @return string
     */
    public function getCreatedDatetime()
    {
        return $this->createdDatetime;
    }

    /**
     * @return string
     */
    public function getUpdatedDatetime()
    {
        return $this->updatedDatetime;
    }

    /**
     * @return array
     */
    public function getCustomDetails()
    {
        return $this->customDetails;
    }

    /**
     * @param $object
     *
     * @return $this
     */
    public function loadFromArray($object)
    {
        unset($this->custom1, $this->custom2, $this->custom3, $this->custom4);

        return parent::loadFromArray($object);
    }

    /**
     * @param $object
     *
     * @return $this ->Object
     */
    public function loadFromArrayForGroups($object)
    {
        parent::loadFromArray($object);

        if (!empty($object->items)) {
            foreach($object->items AS &$item) {
                $Group = new Group();
                $Group->loadFromArray($item);

                $item = $Group;
            }
        }
        return $object;
    }
}
