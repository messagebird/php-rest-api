<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $contacts['ids'] = array(
        '17a15075558ea7221953531c34186632',
        '2a396683558ea7215c96485c48109991'
    );
    $GroupAddContact = $MessageBird->groups->addContacts($contacts, '94a7ca65558e93c97a893b1g15279754');
    var_dump($GroupAddContact);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'Wrong login';

} catch (\Exception $e) {
    var_dump($e->getMessage());
}
