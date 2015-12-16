<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $Hlr             = new \MessageBird\Objects\Hlr();
    $Hlr->msisdn     = '31624971134';
    $Hlr->reference  = "yoloswag3001";

    // create a new hlr request
    $hlr = $MessageBird->lookupHlr->create($Hlr);
    var_dump($hlr);

    // pool for the results
    $poolCount = 10;
    while($poolCount--) {
        $hlr = $MessageBird->lookupHlr->read($Hlr->msisdn);
        if ($hlr->status != \MessageBird\Objects\Hlr::STATUS_SENT) {
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
