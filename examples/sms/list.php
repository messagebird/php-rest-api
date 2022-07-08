<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $messageList = $messageBird->messages->list(['offset' => 100, 'limit' => 30]);
    var_dump($messageList);
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    var_dump($e);
}
