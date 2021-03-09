<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$chatChannel = new \MessageBird\Objects\Chat\Channel();
$chatChannel->name = 'New name';
$chatChannel->callbackUrl = 'http://newurl.dev';

try {
    $chatChannelResult = $messageBird->chatChannels->update($chatChannel, '331af4c577e3asbbc3631455680736');
    var_dump($chatChannelResult);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\Exception $e) {
    echo $e->getMessage();
}
