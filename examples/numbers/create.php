<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('MESSAGEBIRD_API_KEY'); // Set your own API access key here.
$numberPurchaseRequest = new \MessageBird\Objects\NumberPurchaseRequest();
$numberPurchaseRequest->number = '31612345678';
$numberPurchaseRequest->countryCode = 'NL';
$numberPurchaseRequest->billingIntervalMonths = 1;

try {
    $numberPurchaseRequestResult = $messageBird->phoneNumbers->create($numberPurchaseRequest);
    var_dump($numberPurchaseRequestResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    print("wrong login\n");
} catch (\Exception $e) {
    echo $e->getMessage();
}
