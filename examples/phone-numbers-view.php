<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client(getenv("MESSAGEBIRD_API")); // Set your own API access key here.

try {
    $phoneNumbers = $MessageBird->phoneNumbers->getList("nl", array());
    var_dump($phoneNumbers);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    print("wrong login\n");

} catch (\Exception $e) {
    var_dump($e->getMessage());

}
?>
