<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY	'); // Set your own API access key here.

$ChatMessage = new \MessageBird\Objects\ChatMessage();


try {
    $ChatMessageResult = $MessageBird->chatmessages->getList();
    var_dump($ChatMessageResult);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\MessageBird\Exceptions\BalanceException $e) {
    // That means that you are out of credits, so do something about it.
    echo 'no balance';

} catch (\Exception $e) {
    echo $e->getMessage();
}
