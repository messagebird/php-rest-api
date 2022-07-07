<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('MESSAGEBIRD_API_KEY'); // Set your own API access key here.

try {
    $deleted = $messageBird->phoneNumbers->delete('31612345678');
    var_dump('Deleted: ' . $deleted);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    print("wrong login\n");
} catch (\Exception $e) {
    echo $e->getMessage();
}
