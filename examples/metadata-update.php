<?php

// Don't forget to rename credentials-dist.php to credentials.php and insert your API key
require __DIR__ . '/credentials.php';
require __DIR__.'/../vendor/autoload.php';

$bundle = new \Clarify\Bundle($apikey);

$results = $bundle->index();
$items = $results['_links']['items'];

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
}
