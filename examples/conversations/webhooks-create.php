<?php

// Webhooks enable real-time notifications of conversation events to be
// delivered to endpoints on your own server. This example creates a webhook
// that is invoked when new conversations and messages are created in the
// specified channel.

require(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $webhook = new \MessageBird\Objects\Conversation\Webhook();
    $webhook->channelId = 'CHANNEL_ID';
    $webhook->url = 'https://example.com/webhook';
    $webhook->events = array(
        \MessageBird\Objects\Conversation\Webhook::EVENT_CONVERSATION_CREATED,
        \MessageBird\Objects\Conversation\Webhook::EVENT_MESSAGE_CREATED,

        // Other options:
        // \MessageBird\Objects\Conversation\Webhook::EVENT_CONVERSATION_UPDATED,
        // \MessageBird\Objects\Conversation\Webhook::EVENT_MESSAGE_UPDATED,
    );

    $messageBird->conversationWebhooks->create($webhook);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
