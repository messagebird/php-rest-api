<?php

use MessageBird\Common\ResponseError;
use MessageBird\Exceptions\MessageBirdException;
use MessageBird\Objects\Base;

class ResponseErrorTest extends BaseTest
{
    const EXCEPTION_MESSAGE = 'Got error response(s) from the server: %s';

    const SINGLE_ERROR_JSON = '{"errors":[{"code":25,"description":"foo"}]}';
    const MULTIPLE_ERRORS_JSON = '{"errors":[{"code":2,"description":"foo"},{"code":25,"description":"bar"}]}';

    public function testSingleError()
    {
        $this->assertEquals(
            sprintf(self::EXCEPTION_MESSAGE, 'foo'),
            $this->getExceptionMessageFromJson(self::SINGLE_ERROR_JSON)
        );
    }
    
    public function testMultipleErrors()
    {
        $this->assertEquals(
            sprintf(self::EXCEPTION_MESSAGE, 'foo, bar'),
            $this->getExceptionMessageFromJson(self::MULTIPLE_ERRORS_JSON)
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

        $this->fail('No exception thrown');
    }
}
