<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $Lookup = $MessageBird->lookup->read(31624971134);
    var_dump($Lookup);

    $Lookup = $MessageBird->lookup->read("624971134", "NL");
    var_dump($Lookup);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\Exception $e) {
    var_dump($e->getMessage());

}
