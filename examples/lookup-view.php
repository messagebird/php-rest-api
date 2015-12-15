<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('live_q2rh0rCJPmmpbNrJLE8xUtdJv'); // Set your own API access key here.

try {

    $phoneNumber = 31624971134;
    $Lookup = $MessageBird->lookup->read($phoneNumber);
    var_dump($Lookup);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\Exception $e) {
    var_dump($e->getMessage());

}
