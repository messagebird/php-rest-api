<?php

require_once(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $phoneNumber = '31624971134';

    // create a new hlr request
    $hlr = $messageBird->lookupHlr->create('31624971134', 'yoloswag3001');
    var_dump($hlr);

    // pool for the results
    $poolCount = 10;
    while ($poolCount--) {
        $hlr = $messageBird->lookupHlr->read('31624971134');
        if ($hlr->status !== \MessageBird\Objects\Hlr::STATUS_SENT) {
            // we have something
            var_dump($hlr);
            break;
        }
        sleep(0.5);
    }
} catch (\Exception $e) {
    var_dump($e);
}
