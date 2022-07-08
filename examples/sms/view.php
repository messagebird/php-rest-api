<?php

require_once(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $message = $messageBird->messages->read('ad86c8c0153a194a59a17e2b71578856'); // Set a message id here
    var_dump($message);
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    var_dump($e);
}
