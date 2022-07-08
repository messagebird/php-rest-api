<?php

require_once(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$verify = new \MessageBird\Objects\Verify();
$verify->recipient = 31612345678;

$extraOptions = [
    'originator' => 'YourBrand',
    'timeout' => 60,
];

try {
    $verifyResult = $messageBird->verify->create($verify, $extraOptions);
    var_dump($verifyResult);
} catch (\Exception $e) {
    var_dump($e);
}
