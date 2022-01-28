<?php

namespace MessageBird\Objects;

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
}
