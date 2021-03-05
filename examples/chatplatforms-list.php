<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$chatPlatform = new \MessageBird\Objects\Chat\Channel();

try {
    $chatPlatformResult = $messageBird->chatPlatforms->getList();
    var_dump($chatPlatformResult);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\Exception $e) {
    echo $e->getMessage();
}
