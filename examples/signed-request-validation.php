<?php

require_once(__DIR__ . '/../autoload.php');

// Create the validator for incoming requests.
$requestValidator = new \MessageBird\RequestValidator('YOUR_SIGNING_KEY');

// Verify the incoming request from the PHP global variables.
try {
    $request = $requestValidator->validateRequestFromGlobals();
} catch (\MessageBird\Exceptions\ValidationException $e) {
    // The request was invalid, so respond accordingly.
    http_response_code(412);
}

// Or directly verify the signature of the incoming request
$signature = 'JWT_TOKEN_STRING';
$url = 'https://yourdomain.com/path';
$body = 'REQUEST_BODY';

try {
    $request = $requestValidator->validateSignature($signature, $url, $body);
} catch (\MessageBird\Exceptions\ValidationException $e) {
    // The request was invalid, so respond accordingly.
    http_response_code(412);
}
