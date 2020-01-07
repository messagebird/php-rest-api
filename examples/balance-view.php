<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client(getenv('MESSAGEBIRD_API_KEY'));

try {
    $Balance = $MessageBird->balance->read();
    var_dump($Balance);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\Exception $e) {
    var_dump($e->getMessage());

}
