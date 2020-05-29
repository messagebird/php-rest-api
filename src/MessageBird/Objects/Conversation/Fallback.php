<?php

namespace MessageBird\Objects\Conversation;

class Fallback
{
    /**
     * The ID that identifies the channel over which the message should be sent.
     *
     * @var string
     */
    public $from;

    /**
     * This is optional. You can set a time period before attempting to send the fallback.
     * After this time, if the original message isn't in a successfully delivered state, the fallback will be triggered.
     * Formatted as a short-hand duration, for example: "30m" for 30 minutes, "3h" for 3 hours. If the fallback time
     * period isn't specified, 1 minute will be used as the default value.
     *
     * @var string
     */
    public $after;
}