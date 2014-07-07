<?php

namespace MessageBird\Objects;

/**
 * Class Message
 *
 * @package MessageBird\Objects
 */
class Message extends Base
{
    const TYPE_SMS = 'sms';
    const TYPE_BINARY = 'binary';
    const TYPE_PREMIUM = 'premium';

    const DATACODING_UNICODE = 'unicode';
    const DATACODING_PLAIN = 'plain';

    protected $id;

    public $direction = 'mt';
    public $type = self::TYPE_SMS;

    public $originator;
    public $body;
    public $reference;
    public $validity;

    public $gateway;

    public $mclass = 1;
    public $datacoding = self::DATACODING_PLAIN;

    public $typeDetails = array ();

    public $reportUrl;

    public $scheduledDatetime;
    protected $createdDatetime;

    public $recipients = array ();

    /**
     * Send a premium SMS
     *
     * @param $shortcode
     * @param $keyword
     * @param $tariff
     * @param $mid
     */
    public function setPremiumSms($shortcode, $keyword, $tariff, $mid)
    {
        $this->typeDetails['shortcode'] = $shortcode;
        $this->typeDetails['keyword']   = $keyword;
        $this->typeDetails['tariff']    = $tariff;
        $this->typeDetails['mid']       = $mid;

        $this->type = self::TYPE_PREMIUM;
    }

    /**
     * @param $header
     * @param $body
     */
    public function setBinarySms($header, $body)
    {
        $this->typeDetails['udh'] = $header;
        $this->body               = $body;
        $this->type               = self::TYPE_BINARY;
    }

    /**
     * @param $bool
     */
    public function setFlash($bool)
    {
        if ($bool === true) {
            $this->mclass = 0;
        } else {
            $this->mclass = 1;
        }
    }

    /**
     * @param $recipient
     */
    public function addRecipient($recipient)
    {
        $this->recipients[] = $recipient;
    }

    /**
     * Get the created id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}