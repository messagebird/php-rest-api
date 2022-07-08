<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $balance = $messageBird->balance->read();
    var_dump($balance);
} catch (\Exception $e) {
    var_dump($e);
}
