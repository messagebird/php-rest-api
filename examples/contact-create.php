<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$contact             = new \MessageBird\Objects\Contact();
$contact->msisdn = "31123456780";
$contact->firstName = "FirstName";
$contact->lastName = "LastName";
$contact->custom1 = "test_custom1";
$contact->custom2 = "test_custom2";
$contact->custom3 = "test_custom3";
$contact->custom4 = "test_custom4";


try {
    $contactResult = $messageBird->contacts->create($contact);
    var_dump($contactResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'Wrong login';
} catch (\Exception $e) {
    echo $e->getMessage();
}
