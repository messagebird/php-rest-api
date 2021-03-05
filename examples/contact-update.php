<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$contact = new \MessageBird\Objects\Contact();
$contact->msisdn = '31123456789';
$contact->firstName = 'ChangedFirst';
$contact->lastName = "ChangedLast";
$contact->custom1 = "custom-1b";
$contact->custom2 = "custom-2b";
$contact->custom3 = "custom-3b";
$contact->custom4 = "custom-4b";


try {
    $groupResult = $messageBird->contacts->update($contact, 'contact_id');
    var_dump($groupResult);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'Wrong login';

} catch (\Exception $e) {
    echo $e->getMessage();
}
