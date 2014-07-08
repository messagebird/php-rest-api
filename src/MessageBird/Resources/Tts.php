<?php

namespace MessageBird\Resources;

use MessageBird\Objects;
use MessageBird\Common;

/**
 * Class Tts
 *
 * @package MessageBird\Resources
 */
class Tts extends Base
{

    /**
     * @param Common\HttpClient $HttpClient
     */
    public function __construct(Common\HttpClient $HttpClient)
    {
        $this->setObject(new Objects\Tts);
        $this->setResourceName('tts');

        parent::__construct($HttpClient);
    }
}