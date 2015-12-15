<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('live_q2rh0rCJPmmpbNrJLE8xUtdJv'); // Set your own API access key here.

try {
    $Hlr             = new \MessageBird\Objects\Hlr();
    $Hlr->msisdn     = '31624971134';
    $Hlr->reference  = "yoloswag3001";

    // create a new hlr request
    // curl -X POST https://rest.messagebird.com/lookup/31624971134/hlr -H 'Authorization: AccessKey ve_q2rh0rCJPmmpbNrJLE8xUtdJv' -d "msisdn=31624971134" -d "reference=NOIII"
    // curl -H "Accept: application/json" -H "Content-type: application/json" -H 'Authorization: AccessKey ve_q2rh0rCJPmmpbNrJLE8xUtdJv' -X POST -d '{"msisdn":"31624971134","network":null,"reference":"yoloswag3001","status":null}' https://rest.messagebird.com/lookup/31624971134/hlr 

    var_dump(json_encode($Hlr));

    $hlr = $MessageBird->lookupHLR->create($Hlr);

    // pool for the results
    $poolCount = 10;
    while($poolCount--) {
        $hlr = $MessageBird->lookupHLR->read($Hlr->msisdn);
        if ($hlr->status != 'sent') {
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
