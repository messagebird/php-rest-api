<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$ChatChannel = new \MessageBird\Objects\Chat\Channel();
$ChatChannel->name = 'New name';
$ChatChannel->callbackUrl = 'http://newurl.dev';

try {
    $ChatChannelResult = $MessageBird->chatChannels->update($ChatChannel, '331af4c577e3asbbc3631455680736');
    var_dump($ChatChannelResult);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\Exception $e) {
    echo $e->getMessage();
}
