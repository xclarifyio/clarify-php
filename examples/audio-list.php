<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new Op3nvoice\Audio($apikey);

$items = $audio->index();

foreach($items as $item) {

    echo $item['href'] . "\n";

    $item = $audio->load($item['href']);
    echo $item['name'] . "\n";
    $item['_links']['self']['href'] . "\n";
}