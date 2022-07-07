<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $hlrList = $messageBird->hlr->getList(['offset' => 100, 'limit' => 30]);
    var_dump($hlrList);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';
} catch (\Exception $e) {
    var_dump($e->getMessage());
}
