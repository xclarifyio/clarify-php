<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$audio = new \OP3Nvoice\Bundle($apikey);

$items = $audio->index();

/**
 * This is an ugly bit of code but it fully demonstrates the track methods. It starts by loading a list of bundles,
 *   loading each of their tracks. Updating the tracks and then reloading it for display. Then it deletes the
 *   tracks and shows the tracks object again.
 */
foreach ($items as $item) {
    $tracks = $audio->tracks;
    $data = $tracks->load($item['href']);
    print_r($data);

    $tracks->update($item['href'], 1, "an awesome label");
    $data = $tracks->load($item['href']);
    print_r($data);

    $tracks->delete($item['href']);
    $data = $tracks->load($item['href']);

    print_r($data);
}