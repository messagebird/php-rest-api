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
     * The date and time of the last status in RFC3339 format (Y-m-d\TH:i:sP)
     *
     * @var string
     */
    public $statusDatetime;


    /**
     * The details about the status message. More details can be found here:
     * https://developers.messagebird.com/api/sms-messaging/#sms-statuses
     *
     * @var string
     */
    public $statusReason;

    /**
     * Extra error code that describes the failure in more detail (optional, 
     * null if not available)
     *
     * @var string
     */
    public $statusErrorCode;

    /**
     * The name of the recipient’s original country, based on MSISDN.
     *
     * @var string
     */
    public $recipientCountry;

    /**
     * The prefix code for the recipient’s original country, based on MSISDN.
     *
     * @var int
     */
    public $recipientCountryPrefix;

    /**
     * The name of the operator of the recipient. Identified by MCCMNC 
     * of the message.
     *
     * @var string
     */
    public $recipientOperator;

    /**
     * The code of the operator of the message sender. 
     * It could have null value if the message isn’t delivered yet.
     *
     * @var string
     */
    public $mccmnc;

    /**
     * The MCC (Mobile Country Code) part of MCCMNC.
     *
     * @var string
     */
    public $mcc;

    /**
     * The MNC (Mobile Network Code) part of MCCMNC.
     *
     * @var string
     */
    public $mnc;
    
    /**
     * The length of the message in characters. Depends on the 
     * message datacoding.
     *
     * @var int
     */
    public $messageLength;

    /**
     * The count of total messages send. Personalisation not taken in account.
     *
     * @var int
     */
    public $messagePartCount;
}
