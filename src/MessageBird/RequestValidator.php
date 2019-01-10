<?php

namespace MessageBird;

use MessageBird\Objects\SignedRequest;

/**
 * Class RequestValidator
 *
 * @package MessageBird
 */
class RequestValidator
{
    const BODY_HASH_ALGO = 'sha256';
    const HMAC_HASH_ALGO = 'sha256';

    /**
     * The key with which requests will be signed by MessageBird.
     *
     * @var string
     */
    private $signingKey;

    /**
     * RequestValidator constructor.
     *
     * @param string $signingKey
     */
    public function __construct($signingKey)
    {
        $this->signingKey = $signingKey;
    }

    /**
     * Verify that the signed request was submitted from MessageBird using the known key.
     *
     * @param SignedRequest $request
     * @return bool
     */
    public function verify(SignedRequest $request)
    {
        $payload = $this->buildPayloadFromRequest($request);

        $calculatedSignature = \hash_hmac(self::HMAC_HASH_ALGO, $payload, $this->signingKey, true);
        $expectedSignature = \base64_decode($request->signature, true);

        return \hash_equals($expectedSignature, $calculatedSignature);
    }

    private function buildPayloadFromRequest(SignedRequest $request)
    {
        $parts = array();

        // Add request timestamp
        $parts[] = $request->requestTimestamp;

        // Build sorted query string
        $query = $request->queryParameters;
        \ksort($query, SORT_STRING);
        $parts[] = \http_build_query($query);

        // Calculate checksum for request body
        $parts[] = \hash(self::BODY_HASH_ALGO, $request->body, true);

        return \implode("\n", $parts);
    }

    /**
     * Check whether the request was made recently.
     *
     * @param SignedRequest $request The signed request object.
     * @param int $offset The maximum number of seconds that is allowed to consider the request recent
     * @return bool
     */
    public function isRecent(SignedRequest $request, $offset = 10)
    {
        return (\time() - $request->requestTimestamp) < $offset;
    }
}
