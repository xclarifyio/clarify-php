<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new OP3Nvoice\Audio($apikey);

$items = $audio->index();

foreach($items as $item) {
    $metadata = $audio->metadata($item['href']);
    echo $metadata['_links']['self']['href'] . "\n";

    echo $metadata['data'] . "\n\n";
}