<?php

require_once(__DIR__ . '/../autoload.php');

$MessageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $contacts['ids'] = array(
        'contact_id_1',
        'contact_id_2',
    );
    $group_id = 'group_id';
    $GroupAddContact = $MessageBird->groups->addContacts($contacts, $group_id);
    var_dump($GroupAddContact);

} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'Wrong login';

} catch (\Exception $e) {
    var_dump($e->getMessage());
}
