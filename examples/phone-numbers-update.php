<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('MESSAGEBIRD_API_KEY'); // Set your own API access key here.
$number = new \MessageBird\Objects\Number();
$number->tags = ['tag1'];

try {
    $numberResult = $messageBird->phoneNumbers->update($number, '31612345678');
    var_dump($numberResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    print("wrong login\n");

} catch (\Exception $e) {
    echo $e->getMessage();
}
