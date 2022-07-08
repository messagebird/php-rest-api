<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $voiceMessageList = $messageBird->voicemessages->list(['offset' => 100, 'limit' => 30]);
    var_dump($voiceMessageList);
} catch (\Exception $e) {
    var_dump($e);
}
