<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$MmsMessage = new \MessageBird\Objects\MmsMessage();
$MmsMessage->originator = 'MessageBird';
$MmsMessage->recipients = array(31612345678);
$MmsMessage->subject = "Check out this cool MMS";
$MmsMessage->body = 'Have you seen this logo?';
$MmsMessage->mediaUrls = array('https://www.messagebird.com/assets/images/og/messagebird.gif');

try {
    $MmsMessageResult = $MessageBird->mmsMessages->create($MmsMessage);
    var_dump($MmsMessageResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';
} catch (\MessageBird\Exceptions\BalanceException $e) {
    // That means that you are out of credits, so do something about it.
    echo 'no balance';
} catch (\Exception $e) {
    echo $e->getMessage();
}
