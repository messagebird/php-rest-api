<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.
$call = new \MessageBird\Objects\Voice\Call();
$call->source = '31971234567';
$call->destination = '31612345678';
$callFlow = new \MessageBird\Objects\Voice\CallFlow();
$callFlow->title = 'Say message';
$step = new \MessageBird\Objects\Voice\Step();
$step->action = 'say';
$step->options = array(
    'payload' => 'This is a journey into sound.',
    'language' => 'en-GB',
    'voice' => 'male',
);
$callFlow->steps = array($step);
$call->callFlow = $callFlow;

try {
    $result = $messageBird->voiceCalls->create($call);
    var_dump($result);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
