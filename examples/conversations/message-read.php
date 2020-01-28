<?php

// Retrieves a message.

require(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $message = $messageBird->conversationMessages->read('YOUR MESSAGE ID');

    var_dump($message);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
