<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.
$webhook = new \MessageBird\Objects\Voice\Webhook();
$webhook->url = 'https://example.com/status';
$webhook->token = 'foobar';

try {
    $result = $messageBird->voiceWebhooks->create($webhook);
    var_dump($result);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
