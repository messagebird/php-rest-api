<?php

use MessageBird\Objects\SignedRequest;
use MessageBird\RequestValidator;

class RequestValidatorTest extends PHPUnit_Framework_TestCase
{
    public function testVerify()
    {
        $body = '';
        $query = array(
            'recipient' => '31612345678',
            'reference' => 'FOO',
            'statusDatetime' => '2019-01-11T09:17:11+00:00',
            'id' => 'eef0ab57a9e049be946f3821568c2b2e',
            'status' => 'delivered',
            'mccmnc' => '20408',
            'ported' => '1',
        );
        $headers = array(
            'MessageBird-Request-Timestamp' => '1547198231',
            'MessageBird-Signature' => 'KVBdcVdz2lYMwcBLZCRITgxUfA/WkwSi+T3Wxl2HL6w=',
        );

        $request = SignedRequest::create($query, $headers, $body);
        $validator = new RequestValidator('PlLrKaqvZNRR5zAjm42ZT6q1SQxgbbGd');

        $this->assertTrue($validator->verify($request));
    }

    public function testVerificationFails()
    {
        $body = '';
        $query = array(
            'recipient' => '31612345678',
            'reference' => 'BAR',
            'statusDatetime' => '2019-01-11T09:17:11+00:00',
            'id' => 'eef0ab57a9e049be946f3821568c2b2e',
            'status' => 'delivered',
            'mccmnc' => '20408',
            'ported' => '1',
        );
        $headers = array(
            'MessageBird-Request-Timestamp' => '1547198231',
            'MessageBird-Signature' => 'KVBdcVdz2lYMwcBLZCRITgxUfA/WkwSi+T3Wxl2HL6w=',
        );

        $request = SignedRequest::create($query, $headers, $body);
        $validator = new RequestValidator('PlLrKaqvZNRR5zAjm42ZT6q1SQxgbbGd');

        $this->assertFalse($validator->verify($request));
    }

    public function testRecentRequest()
    {
        $body = '';
        $query = array();
        $headers = array(
            'MessageBird-Request-Timestamp' => time() - 1,
            'MessageBird-Signature' => 'KVBdcVdz2lYMwcBLZCRITgxUfA/WkwSi+T3Wxl2HL6w=',
        );

        $request = SignedRequest::create($query, $headers, $body);
        $validator = new RequestValidator('');

        $this->assertTrue($validator->isRecent($request));
    }

    public function testExpiredRequest()
    {
        $body = '';
        $query = array();
        $headers = array(
            'MessageBird-Request-Timestamp' => time() - 100,
            'MessageBird-Signature' => 'KVBdcVdz2lYMwcBLZCRITgxUfA/WkwSi+T3Wxl2HL6w=',
        );

        $request = SignedRequest::create($query, $headers, $body);
        $validator = new RequestValidator('');

        $this->assertFalse($validator->isRecent($request));
    }
}
