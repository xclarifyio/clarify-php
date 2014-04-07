<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new Op3nvoice\Audio($apikey);

$items = $audio->search('does');

foreach($items as $item) {
    $bundle = $audio->load($item['href']);

    echo $bundle['_links']['self']['href'] . "\n";
    echo $bundle['name'] . "\n";
}