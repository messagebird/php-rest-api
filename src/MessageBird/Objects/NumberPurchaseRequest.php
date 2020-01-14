<?php


namespace MessageBird\Objects;

/**
 * Class NumberPurchaseRequest
 *
 * Represents a specific phone number
 *
 * @package MessageBird\Objects
 */
class NumberPurchaseRequest extends Base
{
    /**
     * The phone number in E.164 format without the prefixed plus-sign.
     * @var string
     */
    public $number;

    /**
     * The country code for this number in ISO 3166-1 alpha-2 format.
     *
     * @var string
     */
    public $countryCode;

    /**
     * The interval in months that this number will be billed by
     */
    public $billingIntervalMonths;
}
