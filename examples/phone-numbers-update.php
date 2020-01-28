<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('MESSAGEBIRD_API_KEY'); // Set your own API access key here.
$Number = new \MessageBird\Objects\Number();
$Number->tags = array('tag1');

try {
    $NumberResult = $MessageBird->phoneNumbers->update($Number, '31612345678');
    var_dump($NumberResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    print("wrong login\n");

} catch (\Exception $e) {
    echo $e->getMessage();
}
