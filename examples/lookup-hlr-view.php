<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $hlrObject             = new \MessageBird\Objects\Hlr();
    $hlrObject->msisdn     = '31624971134';
    $hlrObject->reference  = "yoloswag3001";

    // create a new hlr request
    $hlr = $messageBird->lookupHlr->create($hlrObject);
    var_dump($hlr);

    // pool for the results
    $poolCount = 10;
    while($poolCount--) {
        $hlr = $messageBird->lookupHlr->read($hlrObject->msisdn);
        if ($hlr->status !== \MessageBird\Objects\Hlr::STATUS_SENT) {
            // we have something
            var_dump($hlr);
            break;
        }
        sleep(0.5);
    }

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\Exception $e) {
    var_dump($e->getMessage());

}
