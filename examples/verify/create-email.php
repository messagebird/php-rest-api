<?php

use MessageBird\Client;
use MessageBird\Exceptions\AuthenticateException;
use MessageBird\Exceptions\BalanceException;
use MessageBird\Objects\Verify;

require_once(__DIR__ . '/../autoload.php');

$messageBird = new Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$verify = new Verify();
$verify->recipient = 'Client Name <client-email@example.com>';

$extraOptions = [
    'type' => 'email',
    // This email domain needs to be set up as an email channel in your account at https://dashboard.messagebird.com/en/channels/
    'originator' => 'Email Verification <verify@company.com>',
    'timeout' => 60,
];

try {
    $verifyResult = $messageBird->verify->create($verify, $extraOptions);
    var_dump($verifyResult);
} catch (AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';
} catch (BalanceException $e) {
    // That means that you are out of credits, so do something about it.
    echo 'no balance';
} catch (\Exception $e) {
    echo $e->getMessage();
}
