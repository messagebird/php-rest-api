<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('MESSAGEBIRD_API_KEY'); // Set your own API access key here.

try {
    $phoneNumbers = $messageBird->phoneNumbers->getList();
    var_dump($phoneNumbers);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    print("wrong login\n");

} catch (\Exception $e) {
    var_dump($e->getMessage());

}
?>
