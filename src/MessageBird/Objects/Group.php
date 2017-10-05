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
     * The name of the group.
     *
     * @var int
     */
    public $name;

    /**
     * The hash with the contacts in group.
     *
     * @var array
     */
    protected $contacts = array ();

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
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the created href
     *
     * @return string
     */
    public function getHref()
    {
        return $this->href;
    }

    /**
     * Get the $createdDatetime value
     *
     * @return string
     */
    public function getCreatedDatetime()
    {
        return $this->createdDatetime;
    }

    /**
     * Get the $updatedDatetime value
     *
     * @return string
     */
    public function getUpdatedDatetime()
    {
        return $this->createdDatetime;
    }

    /**
     * @param $object
     *
     * @return $this|void
     */
    public function loadFromArray ($object)
    {
        parent::loadFromArray($object);

        if (!empty($object->items)) {
            foreach($object->items AS &$item) {
                $Contact = new Contact();
                $Contact->loadFromArray($item);

                $item = $Contact;
            }
        }

        return $object;
    }
}
