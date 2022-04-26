<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.
$callFlow = new \MessageBird\Objects\Voice\CallFlow();
$step = new \MessageBird\Objects\Voice\Step();
$step->action = 'say';
$step->options = [
    'payload' => 'This is a journey into sound.',
    'language' => 'en-GB',
    'voice' => 'male',
];
$callFlow->steps = [$step];

try {
    $result = $messageBird->voiceCallFlows->create($callFlow);
    var_dump($result);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
