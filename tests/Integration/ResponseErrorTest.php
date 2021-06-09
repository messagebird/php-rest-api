<?php

namespace Tests\Integration;

use MessageBird\Common\ResponseError;
use MessageBird\Exceptions\MessageBirdException;

class ResponseErrorTest extends BaseTest
{
    public const EXCEPTION_MESSAGE = 'Got error response from the server: %s';

    public const SINGLE_ERROR_JSON = '{"errors":[{"code":25,"description":"foo"}]}';
    public const MULTIPLE_ERRORS_JSON = '{"errors":[{"code":9,"description":"foo"},{"code":25,"description":"bar"}]}';

    public function testSingleError()
    {
        self::assertEquals(
            sprintf(self::EXCEPTION_MESSAGE, 'foo'),
            $this->getExceptionMessageFromJson(self::SINGLE_ERROR_JSON)
        );
    }

    private function getExceptionMessageFromJson($json)
    {
        try {
            new ResponseError(json_decode($json));
        } catch (MessageBirdException $e) {
            // Expected: we want the error message.
            return $e->getMessage();
        }

        self::fail('No exception thrown');
    }

    public function testMultipleErrors()
    {
        self::assertEquals(
            sprintf(self::EXCEPTION_MESSAGE, 'bar'),
            $this->getExceptionMessageFromJson(self::MULTIPLE_ERRORS_JSON)
        );
    }
}
