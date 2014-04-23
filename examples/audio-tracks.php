<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new OP3Nvoice\Audio($apikey);

$items = $audio->index();

foreach($items as $item) {
    $trackArray = $audio->tracks->load($item['href']);
    echo $trackArray['_links']['self']['href'] . "\n";

    $tracks = $trackArray['tracks'];
    foreach($tracks as $track) {
        echo $track['media_url'] . "\n\n";
    }
}