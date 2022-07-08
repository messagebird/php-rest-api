<?php

require_once(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $lookup = $messageBird->lookup->read('31624971134');
    var_dump($lookup);

    $lookup = $messageBird->lookup->read("624971134", "NL");
    var_dump($lookup);
} catch (\Exception $e) {
    var_dump($e);
}
