<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$message             = new \MessageBird\Objects\Messages\Message();
$message->originator = 'YourBrand';
$message->recipients = [31612345678];
$message->body       = 'This is a test message.';

try {
    $messageResult = $messageBird->messages->create($message);
    var_dump($messageResult);
} catch (\GuzzleHttp\Exception\GuzzleException $e) {
    var_dump($e);
}
