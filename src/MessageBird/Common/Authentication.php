<?php

namespace MessageBird\Common;

/**
 * Class Authentication
 *
 * @package MessageBird\Common
 */
class Authentication
{
    public string $accessKey;

    /**
     * @param string $accessKey
     */
    public function __construct(string $accessKey)
    {
        $this->accessKey = $accessKey;
    }
}
