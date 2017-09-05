<?php

namespace MessageBird\Common;

use MessageBird\Exceptions;

/**
 * Class ResponseError
 *
 * @package MessageBird\Common
 */
class ResponseError
{

    const SUCCESS = 1;

    const REQUEST_NOT_ALLOWED = 2;

    const MISSING_PARAMS = 9;
    const INVALID_PARAMS = 10;

    const NOT_FOUND = 20;

    const NOT_ENOUGH_CREDIT = 25;

    const CHAT_API_AUTH_ERROR = 1001;

    public $errors = array ();

    /**
     * Load the error data into an array.
     * Throw an exception when important errors are found.
     *
     * @param $body
     *
     * @throws Exceptions\BalanceException
     * @throws Exceptions\AuthenticateException
     */
    public function __construct($body)
    {
        if (!empty($body->errors)) {
            foreach ($body->errors AS $error) {

                if ($error->code === self::NOT_ENOUGH_CREDIT) {
                    throw new Exceptions\BalanceException;
                } elseif ($error->code === self::REQUEST_NOT_ALLOWED) {
                    throw new Exceptions\AuthenticateException;
                } elseif ($error->code === self::CHAT_API_AUTH_ERROR) {
                    throw new Exceptions\AuthenticateException;
                }

                // Rewrite error for Voice API.
                if (!empty($error->message)) {
                    $error->description = $error->message;
                    unset($error->message);
                }

                $this->errors[] = $error;
            }
        }
    }

    /**
     * Get the error string to show in the Exception message.
     *
     * @return string
     */
    public function getErrorString()
    {
        $errorString = array ();
        foreach ($this->errors AS $error) {
            $errorString[] = $error->description;
        }

        return implode(', ', $errorString);
    }
}
