<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$account = new \MessageBird\Objects\PartnerAccount\Account();
$account->name = 'Name Test';

try {
    $partnerAccountResult = $messageBird->partnerAccounts->create($account);
    var_dump($partnerAccountResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';
} catch (\Exception $e) {
    echo $e->getMessage();
}
