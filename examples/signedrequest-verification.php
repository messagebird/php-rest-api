<?php

require_once(__DIR__ . '/../autoload.php');

// Create the validator for incoming requests.
$requestValidator = new \MessageBird\RequestValidator('YOUR_SIGNING_KEY');

// Set up the signed request from the PHP global variables.
try {
    $request = \MessageBird\Objects\SignedRequest::createFromGlobals();
} catch (\MessageBird\Exceptions\ValidationException $e) {
    // The request was missing expected values, so respond accordingly.
    http_response_code(412);
}

if (!$requestValidator->verify($request)) {
    // The request was invalid, so respond accordingly.
    http_response_code(412);
}
