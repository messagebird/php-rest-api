<?php

// Initiates a conversation by sending a first message. This example uses a hsm message.

require(__DIR__ . '/../../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

$hsmParam1 = new \MessageBird\Objects\Conversation\HSM\Params();
$hsmParam1->default = 'YOUR FIRST TEMPLATE PARAM VALUE';

$hsmParam2 = new \MessageBird\Objects\Conversation\HSM\Params();
$hsmParam2->default = 'YOUR SECOND TEMPLATE PARAM VALUE';

$hsmLanguage = new \MessageBird\Objects\Conversation\HSM\Language();
$hsmLanguage->policy = \MessageBird\Objects\Conversation\HSM\Language::DETERMINISTIC_POLICY;
//$hsmLanguage->policy = \MessageBird\Objects\Conversation\HSM\Language::FALLBACK_POLICY;
$hsmLanguage->code = 'YOUR LANGUAGE CODE';

$hsm = new \MessageBird\Objects\Conversation\HSM\Message();
$hsm->templateName = 'YOUR TEMPLATE NAME';
$hsm->namespace = 'YOUR NAMESPACE';
$hsm->params = [$hsmParam1, $hsmParam2];
$hsm->language = $hsmLanguage;

$content = new \MessageBird\Objects\Conversation\Content();
$content->hsm = $hsm;

$message = new \MessageBird\Objects\Conversation\Message();
$message->channelId = 'YOUR CHANNEL ID';
$message->content = $content;
$message->to = 'YOUR MSISDN';
$message->type = 'hsm';

try {
    $conversation = $messageBird->conversations->start($message);

    var_dump($conversation);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
