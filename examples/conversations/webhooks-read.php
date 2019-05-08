<?php

// Webhooks enable real-time notifications of conversation events to be
// delivered to endpoints on your own server. This example retrieves an
// existing webhook.

require(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $webhook = $messageBird->conversationWebhooks->read('WEBHOOK_ID');

    var_dump($webhook);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
