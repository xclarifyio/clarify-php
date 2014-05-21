<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require 'creds.php';
require '../vendor/autoload.php';

$audio = new OP3Nvoice\Bundle($apikey);

$items = $audio->index();

foreach($items as $item) {
    $metadata = $audio->metadata->load($item['href']);

    print_r($metadata);
}