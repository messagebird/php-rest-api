<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$chatChannel = new \MessageBird\Objects\Chat\Channel();

//Example for telegram channel

$chatChannel->name = 'Test Channel Telegram';
$chatChannel->platformId = 'e82d332c5649a5f911e569n69040697';

// Channel details is a hash with name-value pairs indicating which channel details (and their respective data types)
// are required when creating a channel for this platform.

$chatChannel->channelDetails =
    [
        'botName' => 'testBot',
        'token' => '1234566778:A34JT44Yr4amk234352et5hvRnHeAEHA'
    ];

try {
    $chatChannelResult = $messageBird->chatChannels->create($chatChannel);
    var_dump($chatChannelResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';
} catch (\Exception $e) {
    echo $e->getMessage();
}
