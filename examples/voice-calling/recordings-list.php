<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $result = $messageBird->voiceRecordings->getList('c226420d-f107-4db1-b2f9-4646656a90bc', '4f5ab5f4-c4b6-4586-9255-980bb3fd7336', ['offset' => 100, 'limit' => 30]); // Set a call and leg id here
    var_dump($result);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
