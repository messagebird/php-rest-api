<?php

require_once(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $deleted = $messageBird->messages->delete('deb1fe303539efdf1730124b69920283'); // Set a message id here
    var_dump($deleted);
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    var_dump($e);
}
