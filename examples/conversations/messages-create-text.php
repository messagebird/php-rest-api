<?php

// Sends a plain text message to a contact. If there's an active conversation
// with that contact the message will be added to this conversation, otherwise
// it creates a new conversation.

require(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$content = new \MessageBird\Objects\Conversation\Content();
$content->text = 'Hello world';

$message = new \MessageBird\Objects\Conversation\Message();
$message->channelId = 'CHANNEL_ID';
$message->content = $content;
$message->to = 'RECIPIENT';
$message->type = \MessageBird\Objects\Conversation\Content::TYPE_TEXT;

try {
    $conversation = $messageBird->conversationMessages->create(
        'CONVERSATION_ID',
        $message
    );

    var_dump($conversation);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
