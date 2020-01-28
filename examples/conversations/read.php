<?php

// Retrieves a single conversation by its ID.

require(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

// Setting the optional 'include' parameter to 'content' requests the API to
// include the expanded Contact object in its response. Excluded by default.
$optionalParameters = array(
    'include' => 'content',
);

try {
    $conversation = $messageBird->conversations->read(
        'CONVERSATION_ID',
        $optionalParameters
    );

    var_dump($conversation);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
