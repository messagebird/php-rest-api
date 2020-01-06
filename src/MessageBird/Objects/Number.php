<?php


namespace MessageBird\Objects;

/**
 * Class Number
 *
 * Represents a specific phone number
 *
 * @package MessageBird\Objects
 */
class Number extends Base
{
    /**
     * The phone number in E.164 format without the prefixed plus-sign.
     * @var string
     */
    protected $number;

    /**
     * The Number's country
     * @var string
     */
    protected $country;

    /**
     * The country code for this number in ISO 3166-1 alpha-2 format.
     * @var string
     */
    protected $region;

    /**
     * Finer-grained locality for this Number
     * @var string
     */
    protected $locality;

    /**
     * The available features for this Number
     * @var array
     */
    protected $features = array();

    /**
     * Additional user-provided tags for this Number
     * @var array
     */
    protected $tags = array();

    /**
     * Number type (example: landline, mobile).
     * @var string
     */
    protected $type;

    /**
     * Number availability and current activated status
     * @var string
     */
    protected $status;
}
