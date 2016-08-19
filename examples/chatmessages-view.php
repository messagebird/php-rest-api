<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$ChatMessage = new \MessageBird\Objects\Chat\Message();

try {
    $MessageResult = $MessageBird->chatMessages->read('d6508edc578ca7641e3919n79796670'); // Set a message id here
    var_dump($MessageResult);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\Exception $e) {
    echo $e->getMessage();
}
