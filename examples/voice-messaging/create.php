<?php

require_once(__DIR__ . '/../../autoload.php');

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
} catch (\Exception $e) {
    var_dump($e);
}
