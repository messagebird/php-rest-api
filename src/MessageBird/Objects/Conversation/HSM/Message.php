<?php

namespace MessageBird\Objects\Conversation\HSM;

class Message
{
    /**
     * @var string $namespace
     */
    public $namespace;

    /**
     * @var string $templateName
     */
    public $templateName;

    /**
     * @var Language $language
     */
    public $language;

    /**
     * @var Params[] $params
     */
    public $params;
}


