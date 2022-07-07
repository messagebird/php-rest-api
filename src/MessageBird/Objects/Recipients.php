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
     * @param stdClass $object
     * @return $this
     */
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
