<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$hlr            = new \MessageBird\Objects\Hlr();
$hlr->msisdn    = 31612345678;
$hlr->reference = "Custom reference";

try {
    $hlrResult = $messageBird->hlr->create($hlr);
    var_export($hlrResult);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\MessageBird\Exceptions\BalanceException $e) {
    // That means that you are out of credits, so do something about it.
    echo 'no balance';

} catch (\MessageBird\Exceptions\RequestException $e) {
    echo $e->getMessage();

}
