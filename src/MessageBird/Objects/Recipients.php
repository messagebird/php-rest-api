<?php

namespace MessageBird\Objects;

use stdClass;

/**
 * Class Recipients
 *
 * @package MessageBird\Objects
 */
class Recipients extends Base
{
    /**
     * @var int
     */
    public $totalCount;

    /**
     * @var int
     */
    public $totalSentCount;

    /**
     * @var int
     */
    public $totalDeliveredCount;

    /**
     * @var int
     */
    public $totalDeliveryFailedCount;

    /**
     * @var Recipient[]
     */
    public $items;

    /**
     * @deprecated 2.2.0 No longer used by internal code, please switch to {@see self::loadFromStdclass()}
     * 
     * @param $object
     *
     * @return $this|void
     */
    public function loadFromArray($object): self
    {
        parent::loadFromArray($object);

        foreach ($this->items as &$item) {
            $recipient = new Recipient();
            $recipient->loadFromArray($item);

            $item = $recipient;
        }

        return $this;
    }

    public function loadFromStdclass(stdClass $object): self
    {
        parent::loadFromStdclass($object);

        foreach ($this->items as &$item) {
            $recipient = new Recipient();
            $recipient->loadFromStdclass($item);

            $item = $recipient;
        }

        return $this;
    }
}
