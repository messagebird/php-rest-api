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
    const EXCEPTION_MESSAGE = 'Got error response from the server: %s';

    const SUCCESS = 1;

    const REQUEST_NOT_ALLOWED = 2;

    const MISSING_PARAMS = 9;
    const INVALID_PARAMS = 10;

    const NOT_FOUND = 20;

    const NOT_ENOUGH_CREDIT = 25;

    const CHAT_API_AUTH_ERROR = 1001;

    public $errors = array();

    /**
     * Load the error data into an array.
     * Throw an exception when important errors are found.
     *
     * @param $body
     *
     * @throws Exceptions\AuthenticateException
     * @throws Exceptions\BalanceException
     */
    public function __construct($body)
    {
        if (!empty($body->errors)) {
            foreach ($body->errors AS $error) {
                // Voice API returns errors with a "message" field instead of "description".
                // This ensures all errors have a description set.
                if (!empty($error->message)) {
                    $error->description = $error->message;
                    unset($error->message);
                }

                if ($error->code === self::NOT_ENOUGH_CREDIT) {
                    throw new Exceptions\BalanceException($this->getExceptionMessage($error));
                } elseif ($error->code === self::REQUEST_NOT_ALLOWED) {
                    throw new Exceptions\AuthenticateException($this->getExceptionMessage($error));
                } elseif ($error->code === self::CHAT_API_AUTH_ERROR) {
                    throw new Exceptions\AuthenticateException($this->getExceptionMessage($error));
                }

                $this->errors[] = $error;
            }
        }
    }

    /**
     * Get the exception message for the provided error.
     *
     * @param $error
     *
     * @return string
     */
    private function getExceptionMessage($error)
    {
        return sprintf(self::EXCEPTION_MESSAGE, $error->description);
    }

    /**
     * Get a string of all of this response's concatenated error descriptions.
     *
     * @return string
     */
    public function getErrorString()
    {
        $errorDescriptions = array();

        foreach ($this->errors AS $error) {
            $errorDescriptions[] = $error->description;
        }

        return implode(', ', $errorDescriptions);
    }
}
