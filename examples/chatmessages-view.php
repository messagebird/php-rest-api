<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$chatMessage = new \MessageBird\Objects\Chat\Message();

try {
    $messageResult = $messageBird->chatMessages->read('d6508edc578ca7641e3919n79796670'); // Set a message id here
    var_dump($messageResult);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\Exception $e) {
    echo $e->getMessage();
}
