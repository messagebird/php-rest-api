<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$message             = new \MessageBird\Objects\Message();
$message->originator = 'YourBrand';
$message->recipients = [31612345678];
$message->body       = 'This is a test message.';

try {
    $messageResult = $messageBird->messages->create($message);
    var_dump($messageResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';
} catch (\MessageBird\Exceptions\BalanceException $e) {
    // That means that you are out of credits, so do something about it.
    echo 'no balance';
} catch (\Exception $e) {
    echo $e->getMessage();
}
