<?php

namespace MessageBird\Common;

/**
 * Class Authentication
 *
 * @package MessageBird\Common
 */
class Authentication
{

    public $accessKey;

    /**
     * @param $accessKey
     */
    public function __construct($accessKey)
    {
        $this->accessKey = $accessKey;
    }
}
