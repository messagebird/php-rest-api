<?php

require_once(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $hlrResult = $messageBird->hlr->read('c8143db0152a58755c80492h61377581'); // Set a message id here
    var_dump($hlrResult);
} catch (\Exception $e) {
    var_dump($e);
}
