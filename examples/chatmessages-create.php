<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$ChatMessage = new \MessageBird\Objects\Chat\Message();
$ChatMessage->contactId = '9d754dac577e3ff103cdf4n29856560';
$ChatMessage->payload = 'This is a test message to test the Chat API';
$ChatMessage->type = 'text';

try {
    $ChatMessageResult = $MessageBird->chatMessages->create($ChatMessage);
    var_dump($ChatMessageResult);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\MessageBird\Exceptions\BalanceException $e) {
    // That means that you are out of credits, so do something about it.
    echo 'no balance';

} catch (\Exception $e) {
    echo $e->getMessage();
}
