<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new OP3Nvoice\Bundle($apikey);

$items = $audio->index();

foreach($items as $item) {
    $tracks = $audio->tracks->load($item['href']);

    print_r($tracks);
}