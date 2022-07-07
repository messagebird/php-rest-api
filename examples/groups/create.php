<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$group             = new \MessageBird\Objects\Group();
$group->name       = "group_name";

try {
    $groupResult = $messageBird->groups->create($group);
    var_dump($groupResult);
} catch (\MessageBird\Exceptions\AuthenticateException $e) {
    // That means that your accessKey is unknown
    echo 'Wrong login';
} catch (\Exception $e) {
    echo $e->getMessage();
}
