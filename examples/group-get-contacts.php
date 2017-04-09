<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $GroupsContactList = $MessageBird->groups->getContacts('94a7ca65558e93c97a893b1g15279754');
    var_dump($GroupsContactList);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'Wrong login';

} catch (\Exception $e) {
    var_dump($e->getMessage());
}
