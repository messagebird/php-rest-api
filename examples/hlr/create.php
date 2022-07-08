<?php

require_once(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$hlr            = new \MessageBird\Objects\Hlr();
$hlr->msisdn    = 31612345678;
$hlr->reference = "Custom reference";

try {
    $hlrResult = $messageBird->hlr->create($hlr);
    var_export($hlrResult);
} catch (\Exception $e) {
    var_dump($e);
}
