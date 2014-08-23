<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$bundle = new \Clarify\Bundle($apikey);

$success = $bundle->create(
    'name' . rand(0, 500),
    'https://s3-us-west-2.amazonaws.com/op3nvoice/harvard-sentences-1.wav'
);

if ($success) {
    $newURI = $bundle->detail['_links']['self']['href'];
    echo $newURI . "\n";

    $item = $bundle->load($newURI);
    print_r($item);
} else {
    echo $audio->detail['message'] . "\n";
}
