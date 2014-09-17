<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$bundle = new \Clarify\Bundle($apikey);

$results = $bundle->index();
$items = $results['_links']['items'];

/**
 * This gets the first item from our list of bundles, shows the existing tracks, adds three audio tracks, and then
 *   shows the new list of tracks.
 */
foreach ($items as $item) {
    $tracks = $bundle->tracks->load($item['href']);
    print_r($tracks);

    $success = $bundle->tracks->create(
        array(
            'id' => $item['href'],
            'media_url' => 'http://media.clarify.io/audio/samples/harvard-sentences-1.wav',
        )
    );
    $success = $bundle->tracks->create(
        array(
            'id' => $item['href'],
            'media_url' => 'http://media.clarify.io/audio/samples/harvard-sentences-2.wav',
        )
    );
    $success = $bundle->tracks->create(
        array(
            'id' => $item['href'],
            'media_url' => 'http://media.clarify.io/audio/books/dorothyandthewizardinoz_01_baum_64kb.mp3',
        )
    );

    $tracks = $bundle->tracks->load($item['href']);
    print_r($tracks);
    die();
}
