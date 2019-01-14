<?php

require_once(__DIR__.'/../autoload.php');

// Create the validator for incoming requests.
$requestValidator = new \MessageBird\RequestValidator('YOUR_SIGNING_KEY');

// Set up the signed request from the PHP global variables.
$request = \MessageBird\Objects\SignedRequest::createFromGlobals();

if (!$requestValidator->verify($request)) {
    // The request was invalid, so respond accordingly.
    http_response_code(412);
}
