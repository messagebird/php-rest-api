<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $deleted = $messageBird->voiceCallFlows->delete('7d3c2125-4ab4-4dcb-acf9-1c2dbfa24087'); // Set a call flow id here
    var_dump('Deleted: ' . $deleted);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
