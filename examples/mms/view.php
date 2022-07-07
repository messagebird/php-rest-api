<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $mmsResult = $messageBird->mmsMessages->read('mms_message_id'); // Set a MMS Message id
    var_dump($mmsResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
