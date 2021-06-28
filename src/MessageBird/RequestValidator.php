<?php

namespace MessageBird;

use MessageBird\Objects\SignedRequest;

use function base64_decode;
use function hash;
use function hash_equals;
use function hash_hmac;
use function http_build_query;
use function implode;
use function ksort;
use function time;

/**
 * Class RequestValidator
 *
 * @package MessageBird
 */
class RequestValidator
{
    public const BODY_HASH_ALGO = 'sha256';
    public const HMAC_HASH_ALGO = 'sha256';

    /**
     * The key with which requests will be signed by MessageBird.
     *
     * @var string
     */
    private $signingKey;

    /**
     * RequestValidator constructor.
     */
    public function __construct(string $signingKey)
    {
        $this->signingKey = $signingKey;
    }

    /**
     * Verify that the signed request was submitted from MessageBird using the known key.
     */
    public function verify(SignedRequest $signedRequest): bool
    {
        $payload = $this->buildPayloadFromRequest($signedRequest);

        $calculatedSignature = hash_hmac(self::HMAC_HASH_ALGO, $payload, $this->signingKey, true);
        $expectedSignature = base64_decode($signedRequest->signature, true);

        return hash_equals($expectedSignature, $calculatedSignature);
    }

    private function buildPayloadFromRequest(SignedRequest $signedRequest): string
    {
        $parts = [];

        // Add request timestamp
        $parts[] = $signedRequest->requestTimestamp;

        // Build sorted query string
        $query = $signedRequest->queryParameters;
        ksort($query, \SORT_STRING);
        $parts[] = http_build_query($query);

        // Calculate checksum for request body
        $parts[] = hash(self::BODY_HASH_ALGO, $signedRequest->body, true);

        return implode("\n", $parts);
    }

    /**
     * Check whether the request was made recently.
     *
     * @param SignedRequest $signedRequest The signed request object.
     * @param int $offset The maximum number of seconds that is allowed to consider the request recent
     */
    public function isRecent(SignedRequest $signedRequest, int $offset = 10): bool
    {
        return (time() - (int)$signedRequest->requestTimestamp) < $offset;
    }
}
