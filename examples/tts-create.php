<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$TtsMessage             = new \MessageBird\Objects\Tts();
$TtsMessage->recipients = array (31654286496);
$TtsMessage->body = 'This is a test message. The message is converted to speech and the recipient is called on his mobile.';
$TtsMessage->language = 'en-gb';
$TtsMessage->voice = 'female';
$TtsMessage->ifMachine = 'continue'; // We don't care if it is a machine.

try {
    $TtsMessageResult = $MessageBird->tts->create($TtsMessage);
    var_dump($TtsMessageResult);

} catch (MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (MessageBird\Exceptions\BalanceException $e) {
    // That means that you are out of credits, so do something about it.
    echo 'no balance';

} catch (Exception $e) {
    echo $e->getMessage();
}
