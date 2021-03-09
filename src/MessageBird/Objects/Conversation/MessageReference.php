<?php

namespace MessageBird\Objects\Conversation;

use MessageBird\Objects\Base;

/**
 * A link to the messages belonging to a conversation.
 */
class MessageReference extends Base
{
    /**
     * A link to the endpoint to retrieve messages of this conversation.
     *
     * @var string
     */
    public $href;

    /**
     * The total number of messages that can be retrieved for this conversation
     * through pagination.
     *
     * @var int
     */
    public $totalCount;
}
