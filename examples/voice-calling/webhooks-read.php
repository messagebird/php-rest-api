<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $result = $messageBird->voiceWebhooks->read('e5f56d49-4fa2-4802-895d-b0a306f73f76'); // Set a webhook id here
    var_dump($result);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
