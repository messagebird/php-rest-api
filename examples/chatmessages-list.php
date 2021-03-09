<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$chatMessage = new \MessageBird\Objects\Chat\Message();

try {
    $chatMessageResult = $messageBird->chatMessages->getList();
    var_dump($chatMessageResult);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\Exception $e) {
    echo $e->getMessage();
}
