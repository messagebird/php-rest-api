<?php

namespace Tests\Unit;

use DateTime;
use Firebase\JWT\JWT;
use InvalidArgumentException;
use Iterator;
use MessageBird\Exceptions\ValidationException;
use MessageBird\Objects\SignedRequest;
use MessageBird\RequestValidator;
use PHPUnit\Framework\TestCase;

class RequestValidatorTest extends TestCase
{
    /* @deprecated */
    public function testVerify()
    {
        $query = [
            'recipient' => '31612345678',
            'reference' => 'FOO',
            'statusDatetime' => '2019-01-11T09:17:11+00:00',
            'id' => 'eef0ab57a9e049be946f3821568c2b2e',
            'status' => 'delivered',
            'mccmnc' => '20408',
            'ported' => '1',
        ];
        $signature = 'KVBdcVdz2lYMwcBLZCRITgxUfA/WkwSi+T3Wxl2HL6w=';
        $requestTimestamp = 1547198231;
        $body = '';

        $request = SignedRequest::create($query, $signature, $requestTimestamp, $body);
        $validator = new RequestValidator('PlLrKaqvZNRR5zAjm42ZT6q1SQxgbbGd');

        self::assertTrue($validator->verify($request));
    }

    /* @deprecated */
    public function testVerifyWithBody()
    {
        $query = [
            'recipient' => '31612345678',
            'reference' => 'FOO',
            'statusDatetime' => '2019-01-11T09:17:11+00:00',
            'id' => 'eef0ab57a9e049be946f3821568c2b2e',
            'status' => 'delivered',
            'mccmnc' => '20408',
            'ported' => '1',
        ];
        $signature = '2bl+38H4oHVg03pC3bk2LvCB0IHFgfC4cL5HPQ0LdmI=';
        $requestTimestamp = 1547198231;
        $body = '{"foo":"bar"}';

        $request = SignedRequest::create($query, $signature, $requestTimestamp, $body);
        $validator = new RequestValidator('PlLrKaqvZNRR5zAjm42ZT6q1SQxgbbGd');

        self::assertTrue($validator->verify($request));
    }

    /* @deprecated */
    public function testVerificationFails()
    {
        $query = [
            'recipient' => '31612345678',
            'reference' => 'BAR',
            'statusDatetime' => '2019-01-11T09:17:11+00:00',
            'id' => 'eef0ab57a9e049be946f3821568c2b2e',
            'status' => 'delivered',
            'mccmnc' => '20408',
            'ported' => '1',
        ];
        $signature = 'KVBdcVdz2lYMwcBLZCRITgxUfA/WkwSi+T3Wxl2HL6w=';
        $requestTimestamp = 1547198231;
        $body = '';

        $request = SignedRequest::create($query, $signature, $requestTimestamp, $body);
        $validator = new RequestValidator('PlLrKaqvZNRR5zAjm42ZT6q1SQxgbbGd');

        self::assertFalse($validator->verify($request));
    }

    /* @deprecated */
    public function testRecentRequest()
    {
        $query = [];
        $signature = 'KVBdcVdz2lYMwcBLZCRITgxUfA/WkwSi+T3Wxl2HL6w=';
        $requestTimestamp = time() - 1;
        $body = '';

        $request = SignedRequest::create($query, $signature, $requestTimestamp, $body);
        $validator = new RequestValidator('');

        self::assertTrue($validator->isRecent($request));
    }

    /* @deprecated */
    public function testExpiredRequest()
    {
        $query = [];
        $signature = 'KVBdcVdz2lYMwcBLZCRITgxUfA/WkwSi+T3Wxl2HL6w=';
        $requestTimestamp = time() - 100;
        $body = '';

        $request = SignedRequest::create($query, $signature, $requestTimestamp, $body);
        $validator = new RequestValidator('');

        self::assertFalse($validator->isRecent($request));
    }

    const ERROR_MAP = [
        "invalid jwt: signing method none is invalid" => "Algorithm not supported",
        "invalid jwt: claim nbf is in the future" => "Cannot handle token prior to",
        "invalid jwt: claim exp is in the past" => "Expired token",
        "invalid jwt: signature is invalid" => "Signature verification failed"
    ];

    /**
     * Load From Array
     *
     * @dataProvider loadFromArrayDataProvider()
     */
    public function testLoadFromArray($testCase): void
    {
        if (!$testCase['valid']) {
            $this->expectException(ValidationException::class);
            $this->expectExceptionMessage(self::ERROR_MAP[$testCase['reason']] ?? $testCase['reason']);
        }

        $requestValidator = new RequestValidator($testCase['secret'] ?? 'random-secret-to-not-fail-test');

        // Reset JWT timestamp to test case timestamp.
        $d = new DateTime($testCase['timestamp']);
        JWT::$timestamp = $d->getTimestamp();

        $decoded = $requestValidator->validateSignature($testCase['token'], $testCase['url'], $testCase['payload'] ?? '');

        $this->assertNotEmpty($decoded);
    }

    public function loadFromArrayDataProvider()
    {
        $file = dirname(__FILE__) . '/Data/webhooksignature.json';
        if (!is_file($file)) {
            throw new InvalidArgumentException(
                'Could not find test data file from path: "' . $file . '".'
            );
        }

        $jsonData = json_decode(
            file_get_contents($file),
            true
        );
        if ($jsonData === null) {
            throw new InvalidArgumentException(
                'Invalid json: "' . json_last_error_msg() . '".',
                1451045747
            );
        }
        return new WebhookSignatureTestIterator($jsonData);
    }
}

/**
 * Class WebhookSignatureTestIterator
 * @package Tests\Unit
 */
class WebhookSignatureTestIterator implements Iterator
{
    protected $array = [];

    public function __construct($array)
    {
        $this->array = $array;
    }

    function rewind()
    {
        return reset($this->array);
    }

    function current()
    {
        return [current($this->array)];
    }

    function key()
    {
        return current($this->array)['name'];
    }

    function next()
    {
        return [next($this->array)];
    }

    function valid()
    {
        return key($this->array) !== null;
    }
}
