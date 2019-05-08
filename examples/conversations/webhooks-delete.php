<?php

// Webhooks enable real-time notifications of conversation events to be
// delivered to endpoints on your own server. This example deletes an existing
// webhook.

require(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $messageBird->conversationWebhooks->delete('WEBHOOK_ID');
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
