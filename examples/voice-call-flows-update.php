<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.
$callFlow = new \MessageBird\Objects\Voice\CallFlow();
$callFlow->title = 'Foobar updated';

try {
    $result = $messageBird->voiceCallFlows->update($callFlow, '21e5fc51-3285-4f41-97fd-cd1785ab54f8');
    var_dump($result);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
