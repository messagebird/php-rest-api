<?php

namespace MessageBird\Objects\Conversation;

use JsonSerializable;
use MessageBird\Objects\Base;

/**
 * Message that is send via the /send endpoint of the Conversations API
 */
class SendMessage extends Base implements JsonSerializable
{
    /**
     * Either a channel-specific identifier for the receiver (e.g. MSISDN for SMS or WhatsApp channels),
     * or the ID of a MessageBird Contact.
     *
     * @var string
     */
    public $to;

    /**
     * The ID that identifies the channel over which the message should be sent.
     *
     * @var string
     */
    public $from;

    /**
     * Type of this message's content. Possible values: "text", "image",
     * "audio", "video", "file", "location".
     *
     * @var string
     */
    public $type;

    /**
     * Content of the message. Implementation dependent on this message's type.
     *
     * @var Content
     */
    public $content;

    /**
     * The URL for delivery of status reports for the message. Must be HTTPS.
     *
     * @var string
     */
    public $reportUrl;

    /**
     * The additional settings to send a Fallback message if the primary delivery fails
     *
     * @var Fallback
     */
    public $fallback;

    /**
     * The source of the response/action that sent the message.
     *
     * @var \stdClass
     */
    public $source;

    /**
     * Mark the message with a particular MessageBird Message Tag. The meaning and effect of each tag depend on each
     * specific platform.
     *
     * @var string
     */
    public $tag;

    /**
     * Serialize only non empty fields.
     */
    public function jsonSerialize()
    {
        $json = [];
        
        foreach (get_object_vars($this) as $key => $value) {
            if (!empty($value)) {
                $json[$key] = $value;
            }
        }

        return $json;
    }
}
