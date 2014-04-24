<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new OP3Nvoice\Audio($apikey);

$items = $audio->index();

/**
 * This is an ugly bit of code but it fully demonstrates the metadata methods. It starts by loading a list of bundles,
 *   loading each of their metadata. Updating the metadata and then reloading it for display. Then it deletes the
 *   metadata and shows the metadata object again.
 */
foreach($items as $item) {
    $metadata = $audio->metadata;
    $data = $metadata->load($item['href']);
    print_r($data);

    $metadata->update($item['href'], '{"status": "This is awesome!!"}');
    $data = $metadata->load($item['href']);
    print_r($data);

    $metadata->delete($item['href']);
    $data = $metadata->load($item['href']);

    print_r($data);
}