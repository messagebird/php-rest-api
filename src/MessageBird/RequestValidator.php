<?php

namespace MessageBird;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
use MessageBird\Exceptions\ValidationException;
use MessageBird\Objects\SignedRequest;

use function base64_decode;
use function hash;
use function hash_equals;
use function hash_hmac;
use function http_build_query;
use function implode;
use function ksort;
use function PHPUnit\Framework\throwException;
use function time;

/**
 * Class RequestValidator validates request signature signed by MessageBird services.
 *
 * @package MessageBird
 * @see https://developers.messagebird.com/docs/verify-http-requests
 */
class RequestValidator
{
    const BODY_HASH_ALGO = 'sha256';
    const HMAC_HASH_ALGO = 'sha256';
    const ALLOWED_ALGOS = array('HS256', 'HS384', 'HS512');

    /**
     * The key with which requests will be signed by MessageBird.
     *
     * @var string
     */
    private $signingKey;

    /**
     * This field instructs Validator to not validate url_hash claim.
     * It is recommended to not skip URL validation to ensure high security.
     * but the ability to skip URL validation is necessary in some cases, e.g.
     * your service is behind proxy or when you want to validate it yourself.
     * Note that when true, no query parameters should be trusted.
     * Defaults to false.
     *
     * @var bool
     */
    private $skipURLValidation;

    /**
     * RequestValidator constructor.
     *
     * @param string $signingKey customer signature key. Can be retrieved through <a href="https://dashboard.messagebird.com/developers/settings">Developer Settings</a>. This is NOT your API key.
     * @param bool $skipURLValidation whether url_hash claim validation should be skipped. Note that when true, no query parameters should be trusted.
     */
    public function __construct(string $signingKey, bool $skipURLValidation = false)
    {
        $this->signingKey = $signingKey;
        $this->skipURLValidation = $skipURLValidation;
    }

    /**
     * Verify that the signed request was submitted from MessageBird using the known key.
     *
     * @return bool
     * @deprecated Use {@link RequestValidator::validateSignature()} instead.
     */
    public function verify(SignedRequest $signedRequest): bool
    {
        $payload = $this->buildPayloadFromRequest($signedRequest);

        $calculatedSignature = hash_hmac(self::HMAC_HASH_ALGO, $payload, $this->signingKey, true);
        $expectedSignature = base64_decode($signedRequest->signature, true);

        return hash_equals($expectedSignature, $calculatedSignature);
    }

    /**
     * @deprecated Use {@link RequestValidator::validateSignature()} instead.
     */
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
     * @return bool
     * @deprecated Use {@link RequestValidator::validateSignature()} instead.
     */
    public function isRecent(SignedRequest $signedRequest, int $offset = 10): bool
    {
        return (\time() - (int)$signedRequest->requestTimestamp) < $offset;
    }

    /**
     * Validate JWT signature.
     * This JWT is signed with a MessageBird account unique secret key, ensuring the request is from MessageBird and a specific account.
     * The JWT contains the following claims:
     *  - "url_hash" - the raw URL hashed with SHA256 ensuring the URL wasn't altered.
     *  - "payload_hash" - the raw payload hashed with SHA256 ensuring the payload wasn't altered.
     *  - "jti" - a unique token ID to implement an optional non-replay check (NOT validated by default).
     *  - "nbf" - the not before timestamp.
     *  - "exp" - the expiration timestamp is ensuring that a request isn't captured and used at a later time.
     *  - "iss" - the issuer name, always MessageBird.
     *
     * @param string $signature the actual signature taken from request header "MessageBird-Signature-JWT".
     * @param string $url the raw url including the protocol, hostname and query string, {@code https://example.com/?example=42}.
     * @param string $body the raw request body.
     * @return object JWT token payload
     * @throws ValidationException if signature validation fails.
     *
     * @see https://developers.messagebird.com/docs/verify-http-requests
     */
    public function validateSignature(string $signature, string $url, string $body)
    {
        if (empty($signature)) {
            throw new ValidationException("Signature cannot be empty.");
        }
        if (!$this->skipURLValidation && empty($url)) {
            throw new ValidationException("URL cannot be empty");
        }

        JWT::$leeway = 1;
        try {
            $headb64 = \explode('.', $signature)[0];
            $headerRaw = JWT::urlsafeB64Decode($headb64);
            $header = JWT::jsonDecode($headerRaw);

            $key = [];
            if ($header && property_exists($header, 'alg')) {
                if (!in_array(strtoupper($header->alg), self::ALLOWED_ALGOS, true)) {
                    throw new ValidationException('Algorithm not supported');
                }

                $key = new Key($this->signingKey, $header->alg);
            }

            $decoded = JWT::decode($signature, $key);
        } catch (\InvalidArgumentException | \UnexpectedValueException | SignatureInvalidException $e) {
            throw new ValidationException($e->getMessage(), $e->getCode(), $e);
        }

        if (empty($decoded->iss) || $decoded->iss !== 'MessageBird') {
            throw new ValidationException('invalid jwt: claim iss has wrong value');
        }

        if (!$this->skipURLValidation && !hash_equals(hash(self::HMAC_HASH_ALGO, $url), $decoded->url_hash)) {
            throw new ValidationException('invalid jwt: claim url_hash is invalid');
        }

        switch (true) {
            case empty($body) && !empty($decoded->payload_hash):
                throw new ValidationException('invalid jwt: claim payload_hash is set but actual payload is missing');
            case !empty($body) && empty($decoded->payload_hash):
                throw new ValidationException('invalid jwt: claim payload_hash is not set but payload is present');
            case !empty($body) && !hash_equals(hash(self::HMAC_HASH_ALGO, $body), $decoded->payload_hash):
                throw new ValidationException('invalid jwt: claim payload_hash is invalid');
        }

        return $decoded;
    }

    /**
     * Validate request signature from PHP globals.
     *
     * @return object JWT token payload
     * @throws ValidationException if signature validation fails.
     */
    public function validateRequestFromGlobals()
    {
        $signature = $_SERVER['MessageBird-Signature-JWT'] ?? null;
        $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $body = file_get_contents('php://input');

        return $this->validateSignature($signature, $url, $body);
    }
}
