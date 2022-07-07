<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $result = $messageBird->voiceCallFlows->read('f24dd28c-90da-4ed6-af92-d8e32a0e5f55'); // Set a call flow id here
    var_dump($result);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
