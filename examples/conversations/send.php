<?php

// Initiates a conversation by sending a first message, or adding a message to an already existing conversation with
// the same contact as mentioned in "to". This example uses a plain text message, but other types are also available.
// See the conversations-messages-create examples.

require(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$content = new \MessageBird\Objects\Conversation\Content();
$content->text = 'Hello world';

$sendMessage = new \MessageBird\Objects\Conversation\SendMessage();
$sendMessage->from = 'CHANNEL_ID';
$sendMessage->to = 'RECIPIENT'; // Channel-specific, e.g. MSISDN for SMS.
$sendMessage->content = $content;
$sendMessage->type = 'text';

try {
    $sendResult = $messageBird->conversationSend->send($sendMessage);

    var_dump($sendResult);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
