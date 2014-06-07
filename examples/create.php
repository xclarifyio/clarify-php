<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$audio = new \OP3Nvoice\Bundle($apikey);

$success = $audio->create(
    array(
        'media_url' => 'https://s3-us-west-2.amazonaws.com/op3nvoice/harvard-sentences-1.wav',
        'name' => 'name' . rand(0, 500),
    )
);

if ($success) {
    $newURI = $audio->detail['_links']['self']['href'];
    echo $newURI . "\n";

    $item = $audio->load($newURI);
    print_r($item);
} else {
    echo $audio->detail['message'] . "\n";
}
