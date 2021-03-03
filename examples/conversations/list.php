<?php

// Retrieves all conversations for this account. Pagination is supported
// through the optional 'limit' and 'offset' parameters.

require(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

// Take 10 objects, but skip the first 5.
$optionalParameters = [
    'limit' => '10',
    'offset' => '5',
];

try {
    $conversations = $messageBird->conversations->getList($optionalParameters);

    var_dump($conversations);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
