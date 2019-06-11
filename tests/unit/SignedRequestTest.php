<?php

use MessageBird\Objects\SignedRequest;

class SignedRequestTest extends PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $query = array(
            'recipient'      => '31612345678',
            'reference'      => 'FOO',
            'statusDatetime' => '2019-01-11T09:17:11+00:00',
            'id'             => 'eef0ab57a9e049be946f3821568c2b2e',
            'status'         => 'delivered',
            'mccmnc'         => '20408',
            'ported'         => '1',
        );
        $signature = '2bl+38H4oHVg03pC3bk2LvCB0IHFgfC4cL5HPQ0LdmI=';
        $requestTimestamp = 1547198231;
        $body = '{"foo":"bar"}';

        $request = SignedRequest::create($query, $signature, $requestTimestamp, $body);

        self::assertEquals($requestTimestamp, $request->requestTimestamp);
        self::assertEquals($body, $request->body);
        self::assertEquals($query, $request->queryParameters);
        self::assertEquals($signature, $request->signature);
    }

    public function testLoadFromArray()
    {
        $query = array(
            'recipient' => '31612345678',
            'reference' => 'FOO',
            'statusDatetime' => '2019-01-11T09:17:11+00:00',
            'id' => 'eef0ab57a9e049be946f3821568c2b2e',
            'status' => 'delivered',
            'mccmnc' => '20408',
            'ported' => '1',
        );
        $signature = '2bl+38H4oHVg03pC3bk2LvCB0IHFgfC4cL5HPQ0LdmI=';
        $requestTimestamp = 1547198231;
        $body = '{"foo":"bar"}';

        $request = new SignedRequest();
        $request->loadFromArray(array(
            'queryParameters' => $query,
            'signature' => $signature,
            'requestTimestamp' => $requestTimestamp,
            'body' => $body
        ));

        self::assertEquals($requestTimestamp, $request->requestTimestamp);
        self::assertEquals($body, $request->body);
        self::assertEquals($query, $request->queryParameters);
        self::assertEquals($signature, $request->signature);
    }

    /**
     * @expectedException \MessageBird\Exceptions\ValidationException
     * @expectedExceptionMessage query
     */
    public function testLoadInvalidQuery()
    {
        $query = null;
        $signature = '2bl+38H4oHVg03pC3bk2LvCB0IHFgfC4cL5HPQ0LdmI=';
        $requestTimestamp = 1547198231;
        $body = '{"foo":"bar"}';

        $request = new SignedRequest();
        $request->loadFromArray(array(
            'queryParameters' => $query,
            'signature' => $signature,
            'requestTimestamp' => $requestTimestamp,
            'body' => $body
        ));
    }

    /**
     * @expectedException \MessageBird\Exceptions\ValidationException
     * @expectedExceptionMessage signature
     */
    public function testLoadInvalidSignature()
    {
        $query = array(
            'recipient'      => '31612345678',
            'reference'      => 'FOO',
            'statusDatetime' => '2019-01-11T09:17:11+00:00',
            'id'             => 'eef0ab57a9e049be946f3821568c2b2e',
            'status'         => 'delivered',
            'mccmnc'         => '20408',
            'ported'         => '1',
        );
        $signature = null;
        $requestTimestamp = 1547198231;
        $body = '{"foo":"bar"}';

        $request = new SignedRequest();
        $request->loadFromArray(array(
            'queryParameters' => $query,
            'signature' => $signature,
            'requestTimestamp' => $requestTimestamp,
            'body' => $body
        ));
    }

    /**
     * @expectedException \MessageBird\Exceptions\ValidationException
     * @expectedExceptionMessage requestTimestamp
     */
    public function testLoadInvalidTimestamp()
    {
        $query = array(
            'recipient'      => '31612345678',
            'reference'      => 'FOO',
            'statusDatetime' => '2019-01-11T09:17:11+00:00',
            'id'             => 'eef0ab57a9e049be946f3821568c2b2e',
            'status'         => 'delivered',
            'mccmnc'         => '20408',
            'ported'         => '1',
        );
        $signature = '2bl+38H4oHVg03pC3bk2LvCB0IHFgfC4cL5HPQ0LdmI=';
        $requestTimestamp = null;
        $body = '{"foo":"bar"}';

        $request = new SignedRequest();
        $request->loadFromArray(array(
            'queryParameters' => $query,
            'signature' => $signature,
            'requestTimestamp' => $requestTimestamp,
            'body' => $body
        ));
    }

    /**
     * @expectedException \MessageBird\Exceptions\ValidationException
     * @expectedExceptionMessage body
     */
    public function testLoadInvalidBody()
    {
        $query = array(
            'recipient'      => '31612345678',
            'reference'      => 'FOO',
            'statusDatetime' => '2019-01-11T09:17:11+00:00',
            'id'             => 'eef0ab57a9e049be946f3821568c2b2e',
            'status'         => 'delivered',
            'mccmnc'         => '20408',
            'ported'         => '1',
        );
        $signature = '2bl+38H4oHVg03pC3bk2LvCB0IHFgfC4cL5HPQ0LdmI=';
        $requestTimestamp = 1547198231;
        $body = null;

        $request = new SignedRequest();
        $request->loadFromArray(array(
            'queryParameters' => $query,
            'signature' => $signature,
            'requestTimestamp' => $requestTimestamp,
            'body' => $body
        ));
    }
}
