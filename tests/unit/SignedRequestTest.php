<?php

use MessageBird\Objects\SignedRequest;

class SignedRequestTest extends PHPUnit_Framework_TestCase
{
    public function testValidFields()
    {
        $body = '{"a key": "some value"}';
        $query = 'def=bar&abc=foo';
        $headers = array(
            'MessageBird-Request-Timestamp' => '1544544948',
            'MessageBird-Signature' => 'TWVzc2FnZUJpcmQ=',
        );

        $signedRequest = SignedRequest::create($query, $headers, $body);

        $this->assertTrue(hash_equals(hash('sha256', $body, true), $signedRequest->getBodyChecksum()));
        $this->assertEquals('abc=foo&def=bar', $signedRequest->getSortedQueryParameters());
        $this->assertEquals('1544544948', $signedRequest->getRequestTimestamp());
        $this->assertEquals('MessageBird', $signedRequest->getSignature());
    }
}
