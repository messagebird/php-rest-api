<?php


namespace MessageBird\Objects;

/**
 * Class Recipient
 *
 * @package MessageBird\Objects
 */
class Recipient extends Base
{
    /**
     * The msisdn of the recipient
     *
     * @var int
     */
    public $recipient;

    /**
     * The status of the message sent to the recipient.
     * Possible values for SMS are: scheduled, sent, buffered,
     * delivered, delivery_failed
     *
     * Possible values for voice messages are: calling, answered,
     * failed, busy, machine
     *
     * @var string
     */
    public $status;

    /**
     * The datum time of the last status in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    public $statusDatetime;
}
