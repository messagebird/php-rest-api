<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('MESSAGEBIRD_API_KEY');

try {
    $phoneNumbers = $MessageBird->availablePhoneNumbers->getList("nl", array());
    var_dump($phoneNumbers);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    var_dump($e->getMessage());
    // That means that your accessKey is unknown
    print("wrong login\n");

} catch (\Exception $e) {
    var_dump($e->getMessage());

}
?>
