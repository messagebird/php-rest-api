<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$mmsMessage = new \MessageBird\Objects\MmsMessage();
$mmsMessage->originator = 'YourNumber';
$mmsMessage->recipients = [31612345678];
$mmsMessage->subject = "Check out this cool MMS";
$mmsMessage->body = 'Have you seen this logo?';
$mmsMessage->mediaUrls = ['https://www.messagebird.com/assets/images/og/messagebird.gif'];

try {
    $mmsMessageResult = $messageBird->mmsMessages->create($mmsMessage);
    var_dump($mmsMessageResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';
} catch (\MessageBird\Exceptions\BalanceException $e) {
    // That means that you are out of credits, so do something about it.
    echo 'no balance';
} catch (\Exception $e) {
    echo $e->getMessage();
}
