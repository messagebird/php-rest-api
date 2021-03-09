<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$voiceMessage             = new \MessageBird\Objects\VoiceMessage();
$voiceMessage->recipients =  [31654286496];
$voiceMessage->body = 'This is a test message. The message is converted to speech and the recipient is called on his mobile.';
$voiceMessage->language = 'en-gb';
$voiceMessage->voice = 'female';
$voiceMessage->ifMachine = 'continue'; // We don't care if it is a machine.

try {
    $voiceMessageResult = $messageBird->voicemessages->create($voiceMessage);
    var_dump($voiceMessageResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';
} catch (\MessageBird\Exceptions\BalanceException $e) {
    // That means that you are out of credits, so do something about it.
    echo 'no balance';
} catch (\Exception $e) {
    echo $e->getMessage();
}
