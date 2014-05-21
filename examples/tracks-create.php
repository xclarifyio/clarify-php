<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require 'creds.php';
require '../vendor/autoload.php';

$audio = new OP3Nvoice\Bundle($apikey);

$items = $audio->index();

/**
 * This gets the first item from our list of bundles, shows the existing tracks, adds three audio tracks, and then
 *   shows the new list of tracks.
 */
foreach($items as $item) {
    $tracks = $audio->tracks->load($item['href']);
    print_r($tracks);

    $success = $audio->tracks->create($item['href'], 'https://s3-us-west-2.amazonaws.com/op3nvoice/harvard-sentences-1.wav');
    $success = $audio->tracks->create($item['href'], 'https://s3-us-west-2.amazonaws.com/op3nvoice/harvard-sentences-2.wav');
    $success = $audio->tracks->create($item['href'], 'https://s3-us-west-2.amazonaws.com/op3nvoice/dorothyandthewizardinoz_01_baum_64kb.mp3');

    $tracks = $audio->tracks->load($item['href']);
    print_r($tracks);
    die();
}