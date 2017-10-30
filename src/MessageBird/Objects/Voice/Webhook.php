<?php

namespace MessageBird\Objects\Voice;

use MessageBird\Objects\Base;

class Webhook extends Base
{
    /**
     * The unique ID of the webhook
     *
     * @var string
     */
    protected $id;

    /**
     * The callback URL that will be requested when the MessageBird platform sends a webhook.
     *
     * @var string
     */
    public $url;

    /**
     * The secret used for signing webhook requests.
     *
     * @var string
     * @see https://developers.messagebird.com/docs/voice-calling#handle-callbacks
     */
    public $token;

    /**
     * The date and time the webhook was created
     *
     * @var string
     */
    protected $createdAt;

    /**
     * The date and time the webhook was last updated
     *
     * @var string
     */
    protected $updatedAt;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
