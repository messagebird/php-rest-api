<?php

namespace MessageBird\Objects\Conversation;

use MessageBird\Objects\Base;
use stdClass;

/**
 * Represents a counterparty with who messages can be exchanged.
 */
class Contact extends Base
{
    /**
     * A unique ID generated by the MessageBird platform that identifies the
     * contact.
     *
     * @var string
     */
    public string $id;

    /**
     * The URL of this contact object.
     *
     * @var string
     */
    public string $href;

    /**
     * The MSISDN/phone number of this contact.
     *
     * @var int|null
     */
    public ?int $msisdn;

    /**
     * @var string
     */
    public string $firstName;

    /**
     * @var string
     */
    public string $lastName;

    /**
     * An associative array containing additional details about this contact.
     *
     * @var array
     */
    public $customDetails;

    /**
     * The date and time when this contact was first created in RFC3339
     * format.
     *
     * @var string
     */
    public string $createdDatetime;

    /**
     * The date and time when this contact was most recently updated in
     * RFC3339 format.
     *
     * @var string
     */
    public string $updatedDatetime;

    /**
     * @param stdClass $object
     * @return $this
     */
    public function loadFromStdclass(stdClass $object): self
    {
        parent::loadFromStdclass($object);

        if (!empty($this->customDetails)) {
            $this->customDetails = (array)$this->customDetails;
        }

        return $this;
    }
}
