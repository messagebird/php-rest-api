<?php

// Initiates a conversation by sending a first message, or adding a message to an already existing conversation with
// the same contact as mentioned in "to". This example uses a plain text message, but other types are also available.
// See the conversations-messages-create examples.

require(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$content = new \MessageBird\Objects\Conversation\Content();
$content->text = 'Hello world';

$message = new \MessageBird\Objects\Conversation\SendMessage();
$message->from = 'CHANNEL_ID';
$message->to = 'RECIPIENT'; // Channel-specific, e.g. MSISDN for SMS.
$message->content = $content;
$message->type = 'text';

try {
    $sendMessage = $messageBird->conversationSend->send($message);

    var_dump($sendMessage);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
