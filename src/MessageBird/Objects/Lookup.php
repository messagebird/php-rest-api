<?php

namespace MessageBird\Objects;

use stdClass;

/**
 * Class Lookup
 *
 * @package MessageBird\Objects
 */
class Lookup extends Base
{
    public const TYPE_FIXED_LINE = "fixed line";
    public const TYPE_MOBILE = "mobile";
    public const TYPE_FIXED_LINE_OR_MOBILE = "fixed line or mobile";
    public const TYPE_TOLL_FREE = "toll free";
    public const TYPE_PREMIUM_RATE = "premium rate";
    public const TYPE_SHARED_COST = "shared cost";
    public const TYPE_VOIP = "voip";
    public const TYPE_PERSONAL_NUMBER = "personal number";
    public const TYPE_PAGER = "pager";
    public const TYPE_UNIVERSAL_ACCESS_NUMBER = "universal access number";
    public const TYPE_VOICE_MAIL = "voice mail";
    public const TYPE_UNKNOWN = "unknown";

    /**
     * The URL of the created object.
     *
     * @var string
     */
    protected $href;
    /**
     * The country code for this number in ISO 3166-1 alpha-2 format.
     *
     * @var string
     */
    protected $countryCode;

    /**
     * The country calling code for this number.
     *
     * @var integer
     */
    protected $countryPrefix;

    /**
     * The phone number in E.164 format without the prefixed plus-sign.
     *
     * @var integer
     */
    protected $phoneNumber;

    /**
     * The type of number. This can be fixed line, mobile, fixed line or mobile, toll free, premium rate, shared cost, voip, personal number, pager, universal access number, voice mail or unknown*
     * @var string
     */
    protected $type;

    /**
     * An associative array containing references to this phone number in several different formats.
     *
     * @var array
     *
     * e164: The phone number in E.164 format.
     * international: The phone number in international format.
     * national: The phone number in national/local format.
     * rfc3966: The phone number in RFC3966 format.
     */
    protected $formats;

    /**
     * The most recent HLR object. If no such HLR objects exists, this array won't be returned.
     *
     * @var array
     *
     * id(string): An unique random ID which is created on the MessageBird platform.
     * network(int): The MCCMNC code of the network provider.
     * reference(string): A client reference.
     * status(string): The status of the HLR request. Possible values: sent, absent, active, unknown, and failed.
     * createdDatetime(datetime): The date and time of the creation of the message in RFC3339 format (Y-m-d\TH:i:sP).
     * statusDatetime(datetime): The datum time of the last status in RFC3339 format (Y-m-d\TH:i:sP).
     */
    protected $hlr;

    public function getHref(): ?string
    {
        return $this->href;
    }

    public function getCountryCode(): ?string
    {
        return $this->countryCode;
    }

    public function getCountryPrefix(): ?int
    {
        return $this->countryPrefix;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function getFormats(): ?array
    {
        return $this->formats;
    }

    public function getHLR(): ?array
    {
        return $this->hlr;
    }

    /**
     * @deprecated 2.2.0 No longer used by internal code, please switch to {@see self::loadFromStdclass()}
     * 
     * @param mixed $object
     *
     * @return $this
     */
    public function loadFromArray($object): self
    {
        unset($this->hlr);
        return parent::loadFromArray($object);
    }

    public function loadFromStdclass(stdClass $object): self
    {
        unset($this->hlr);
        return parent::loadFromStdclass($object);
    }
}
