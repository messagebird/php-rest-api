<?php

namespace Tests\Unit;

use DateTime;
use Firebase\JWT\JWT;
use InvalidArgumentException;
use Iterator;
use MessageBird\Exceptions\ValidationException;
use MessageBird\RequestValidator;
use PHPUnit\Framework\TestCase;

class RequestValidatorTest extends TestCase
{
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

    function rewind(): void
    {
        reset($this->array);
    }

    function current(): array
    {
        return [current($this->array)];
    }

    #[\ReturnTypeWillChange]
    function key()
    {
        return current($this->array)['name'];
    }

    function next(): void
    {
        next($this->array);
    }

    function valid(): bool
    {
        return key($this->array) !== null;
    }
}
