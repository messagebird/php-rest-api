<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $deleted = $MessageBird->chatContacts->delete('4affa2345d7fb22e373921n524df5409'); // Set a contact id
    var_dump('Deleted : ' . $deleted);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\Exception $e) {
    echo $e->getMessage();
}
