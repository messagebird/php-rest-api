<?php

// Sends a HSM message to a contact. See:
// https://developers.messagebird.com/docs/conversations#hsm-messages-for-whatsapp
// If there's an active conversation with that contact the message will be
// added to this conversation, otherwise it creates a new conversation.

require(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$hsm = new \MessageBird\Objects\Conversation\Hsm();
$hsm->namespace = 'NAMESPACE';
$hsm->templateName = 'TEMPLATE';
$hsm->setLanguage('en_US', \MessageBird\Objects\Conversation\Hsm::LANGUAGE_POLICY_DETERMINISTIC);
$hsm->addParam(\MessageBird\Objects\Conversation\HsmParam::currency('EUR 12,34', 'EUR', 12340));
$hsm->addParam(\MessageBird\Objects\Conversation\HsmParam::dateTime('can not localize', 'RFC3339_DATETIME'));

$message = new \MessageBird\Objects\Conversation\Message();
$message->channelId = 'CHANNEL_ID';
$message->content = $hsm->toContent();
$message->to = 'RECIPIENT';
$message->type = \MessageBird\Objects\Conversation\Content::TYPE_HSM;

try {
    $conversation = $messageBird->conversationMessages->create(
        'CONVERSATION_ID',
        $message
    );

    var_dump($conversation);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
