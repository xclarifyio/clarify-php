<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$audio = new \OP3Nvoice\Bundle($apikey);

$items = $audio->index();

foreach ($items as $item) {
    $tracks = $audio->tracks;
    $data = $tracks->load($item['href']);
    print_r($data);

    $tracks->update($item['href'], 2, "an awesome label");
    $data = $tracks->load($item['href']);
    print_r($data);
}