<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$chatMessage = new \MessageBird\Objects\Chat\Message();
$chatMessage->contactId = '9d754dac577e3ff103cdf4n29856560';
$chatMessage->payload = 'This is a test message to test the Chat API';
$chatMessage->type = 'text';

try {
    $chatMessageResult = $messageBird->chatMessages->create($chatMessage);
    var_dump($chatMessageResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';
} catch (\MessageBird\Exceptions\BalanceException $e) {
    // That means that you are out of credits, so do something about it.
    echo 'no balance';
} catch (\Exception $e) {
    echo $e->getMessage();
}
