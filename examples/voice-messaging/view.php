<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $voiceMessageResult = $messageBird->voicemessages->read('ca0a8220453bc36ddeb3115a37400870'); // Set a message id here
    var_dump($voiceMessageResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
