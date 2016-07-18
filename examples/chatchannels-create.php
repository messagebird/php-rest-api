<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY	'); // Set your own API access key here.

$ChatChannel = new \MessageBird\Objects\ChatChannel();

//Example for telegram channel

$ChatChannel->name = 'Test Channel Telegram';
$ChatChannel->platform_id = 'e82d332c5649a5f911e569n69040697';

/*
 *
 * Channel details is a hash with name-value pairs indicating which channel details (and their respective data types)
 * are required when creating a channel for this platform.
 *
 * Template hashes are JSON objects which contain name-value pairs that indicate the parameter names
 * and respective data types which are required when creating a related object.
 * The contactTemplate relates to the contactDetails parameter of a contact object.
 * The channelTemplate relates to the channelDetails parameter of a channel object.
 * Hash names ending in |empty denote parameters which are optional.
 *
 */

$ChatChannel->channelDetails =
    array(
        'botName' => 'testBot',
        'token' => '1234566778:A34JT44Yr4amk234352et5hvRnHeAEHA'
    );

try {
    $ChatChannelResult = $MessageBird->chatchannels->create($ChatChannel);
    var_dump($ChatChannelResult);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'wrong login';

} catch (\Exception $e) {
    echo $e->getMessage();
}
