<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $contactList = $messageBird->contacts->getList([]);
    var_dump($contactList);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'Wrong login';
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
