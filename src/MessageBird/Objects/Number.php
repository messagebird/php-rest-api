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
    public $number;

    /**
     * The Number's country
     * @var string
     */
    public $country;

    /**
     * The country code for this number in ISO 3166-1 alpha-2 format.
     * @var string
     */
    public $region;

    /**
     * Finer-grained locality for this Number
     * @var string
     */
    public $locality;

    /**
     * The available features for this Number
     * @var array
     */
    public $features;

    /**
     * Additional user-provided tags for this Number
     * @var array
     */
    public $tags = [];

    /**
     * Number type (example: landline, mobile).
     * @var string
     */
    public $type;

    /**
     * Number availability and current activated status
     * @var string
     */
    public $status;
}
