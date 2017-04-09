<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$Contact             = new \MessageBird\Objects\Contact();
$Contact->msisdn = "31633632125";
$Contact->firstName = "sdsaf555";
$Contact->lastName = "sagagagtname667";
$Contact->custom1 = "testcustom1";
$Contact->custom2 = "testcustom2";
$Contact->custom3 = "testcustom3";
$Contact->custom4 = "testcusto4";


try {
    $ContactResult = $MessageBird->contacts->create($Contact);
    var_dump($ContactResult);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'Wrong login';

} catch (\Exception $e) {
    echo $e->getMessage();
}
