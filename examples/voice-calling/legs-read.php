<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $result = $messageBird->voiceLegs->read('dbf1373c-6781-43c7-bfe4-6538583c444b', '6f39d883-94ac-4068-9fed-a9e31b77acda'); // Set a call and leg id here
    var_dump($result);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
