<?php

use MessageBird\Objects\SignedRequest;
use PHPUnit\Framework\TestCase;

class SignedRequestTest extends TestCase
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

    public function testLoadInvalidQuery()
    {
        $this->expectException(\MessageBird\Exceptions\ValidationException::class);
        $this->expectExceptionMessage('query');
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

    public function testLoadInvalidSignature()
    {
        $this->expectException(\MessageBird\Exceptions\ValidationException::class);
        $this->expectExceptionMessage('signature');
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

    public function testLoadInvalidTimestamp()
    {
        $this->expectException(\MessageBird\Exceptions\ValidationException::class);
        $this->expectExceptionMessage('requestTimestamp');
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

    public function testLoadInvalidBody()
    {
        $this->expectException(\MessageBird\Exceptions\ValidationException::class);
        $this->expectExceptionMessage('body');
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
