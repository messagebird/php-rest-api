<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY	'); // Set your own API access key here.

$ChatChannel = new \MessageBird\Objects\ChatChannel();


try {
    $ChatChannelResult = $MessageBird->chatchannels->read('0051af4c577e3eebbc3631n95680736'); // Set a message id here
    var_dump($ChatChannelResult);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\Exception $e) {
    echo $e->getMessage();
}
