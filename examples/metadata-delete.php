<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$bundle = new \Clarify\Bundle($apikey);

$results = $bundle->index();
$items = $results['_links']['items'];

/**
 * This is an ugly bit of code but it fully demonstrates the metadata methods. It starts by loading a list of bundles,
 *   loading each of their metadata. Updating the metadata and then reloading it for display. Then it deletes the
 *   metadata and shows the metadata object again.
 */
foreach ($items as $item) {
    $metadata = $bundle->metadata;
    $data = $metadata->load($item['href']);
    print_r($data);

    $metadata->update(
        array(
            'id' => $item['href'],
            'data' => '{"status": "This is awesome!!"}',
        )
    );
    $data = $metadata->load($item['href']);
    print_r($data);

    $metadata->delete($item['href']);
    $data = $metadata->load($item['href']);

    print_r($data);
}
