<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('MESSAGEBIRD_API_KEY'); // Set your own API access key here.
$NumberPurchaseRequest = new \MessageBird\Objects\NumberPurchaseRequest();
$NumberPurchaseRequest->number = '31612345678';
$NumberPurchaseRequest->countryCode = 'NL';
$NumberPurchaseRequest->billingIntervalMonths = 1;

try {
    $NumberPurchaseRequestResult = $MessageBird->phoneNumbers->create($NumberPurchaseRequest);
    var_dump($NumberPurchaseRequestResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    print("wrong login\n");

} catch (\Exception $e) {
    echo $e->getMessage();
}
