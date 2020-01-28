<?php

// Updating the conversation allows moving them between 'active' and 'archived'
// status. This example restores an archived conversation by setting it to active.

require(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $conversationId = 'CONVERSATION_ID';
    $conversation = $messageBird->conversations->read($conversationId);

    $conversation->status = \MessageBird\Objects\Conversation\Conversation::STATUS_ACTIVE;
    $messageBird->conversations->update($conversation, $conversationId);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
