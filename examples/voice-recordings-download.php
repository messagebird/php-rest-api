<?php

require_once(__DIR__ . '/../autoload.php');

$messageBird = new \MessageBird\Client('YOUR_ACCESS_KEY'); // Set your own API access key here.

try {
    $data = $messageBird->voiceRecordings->download('c226420d-f107-4db1-b2f9-4646656a90bc', '4f5ab5f4-c4b6-4586-9255-980bb3fd7336', 'a94f7d51-19b5-4eb8-9e8e-90fce490a577'); // Set call, leg and recording id here
    echo sprintf("Received %d bytes.\n", mb_strlen($data));
    $tmpfname = tempnam('/tmp', 'voice-recording-');
    $handle = fopen($tmpfname, "w");
    fwrite($handle, $data);
    fclose($handle);
    echo sprintf("Wrote to file: %s\n", $tmpfname);
} catch (\Exception $e) {
    echo sprintf("%s: %s", get_class($e), $e->getMessage());
}
