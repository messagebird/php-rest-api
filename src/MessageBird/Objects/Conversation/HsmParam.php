<?php

namespace MessageBird\Objects\Conversation;

use MessageBird\Objects\Base;

/**
 * HsmParam sets parameters for a WhatsApp HSM message. Using the static
 * factories is advised. See:
 * https://developers.messagebird.com/docs/conversations#hsm-localizable-parameters-object
 */
class HsmParam extends Base
{
    /**
     * @var string
     */
    public $default;

    /**
     * Contains a currency code and amount. The amount is multiplied by 1000.
     * When your amount is 12.34, set this value to 12,340.
     * 
     * @var array
     */
    public $currency;

    /**
     * @var string
     */
    public $dateTime;

    /**
     * @param $object
     *
     * @return $this
     */
    public function loadFromArray($object)
    {
        parent::loadFromArray($object);

        if (!empty($this->currency)) {
            // Cast stdClass to associative array.
            $this->currency = (array) $this->currency;
        }

        return $this;
    }

    /**
     * Set a text param.
     * 
     * @param string $default
     */
    public static function text($default)
    {
        $instance = new static();
        $instance->default = $default;

        return $instance;
    }

    /**
     * Set a localized currency. Code must be ISO 4217 compliant, and the
     * amount should be multiplied by 1000. The default is used when
     * localization fails.
     * Currency can only be set if datetime is not present.
     * 
     * @param string $default
     * @param string $code
     * @param int $amount
     */ 
    public static function currency($default, $code, $amount)
    {
        $instance = new static();
        $instance->default = $default;
        $instance->currency = array(
            'currencyCode' => $code,
            'amount' => $amount,
        );

        return $instance;
    }

    /**
     * RFC 3339 compliant string representation of a datetime. The default is
     * used when localization fails.
     * Datetime can only be set if currency is not present.
     * 
     * @param string $default
     * @param string $dateTime
     */
    public static function dateTime($default, $dateTime)
    {
        $instance = new static();
        $instance->default = $default;
        $instance->dateTime = $dateTime;

        return $instance;
    }
}