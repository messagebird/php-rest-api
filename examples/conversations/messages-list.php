<?php

// Retrieves all messages from the conversation. Pagination is supported
// through the optional 'limit' and 'offset' parameters.

require(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $messages = $messageBird->conversationMessages->getList('CONVERSATION_ID');

    var_dump($messages);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
