<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new OP3Nvoice\Audio($apikey);

$items = $audio->index();

foreach($items as $item) {
    $tracks = $audio->tracks;
    $data = $tracks->load($item['href']);
    print_r($data);

    $tracks->update($item['href'], 2, "an awesome label");
    $data = $tracks->load($item['href']);
    print_r($data);
}