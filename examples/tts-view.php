<?php

date_default_timezone_set('Europe/Amsterdam');

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $TtsMessageResult = $MessageBird->tts->read('ca0a8220453bc36ddeb3115a37400870'); // Set a message id here
    var_dump($TtsMessageResult);

} catch (MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (Exception $e) {
    var_dump($e->getMessage());
}

