<?php

namespace MessageBird\Objects;

/**
 * Class Balance
 *
 * @package MessageBird\Objects
 */
class Balance extends Base
{
    /**
     * Your payment method. Possible values are: prepaid & postpaid
     *
     * @var string
     */
    public $payment;

    /**
     * Your payment type. Possible values are: credits & euros
     *
     * @var string
     */
    public $type;

    /**
     * The amount of balance of the payment type. When postpaid is your payment method, the amount will be 0.
     *
     * @var float
     */
    public $amount;
}
