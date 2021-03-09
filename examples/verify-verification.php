<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $verifyResult = $messageBird->verify->verify('05a90ee1155d2f4cdd12440v10006813', '585438'); // Set a message id and the token here.
    var_dump($verifyResult);

    // Check if $verifyResult->getStatus() === MessageBird\Objects\Verify::STATUS_VERIFIED

} catch (\MessageBird\Exceptions\RequestException $e) {
    echo 'token incorrect';
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\Exception $e) {
    echo $e->getMessage();
}
