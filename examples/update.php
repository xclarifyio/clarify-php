<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$bundle = new \Clarify\Bundle($apikey);

$results = $bundle->index();
$items = $results['_links']['items'];

foreach ($items as $item) {
    $bundle = $bundle->load($item['href']);

    $id = $bundle['_links']['self']['href'];
    echo $id . "\n";
    echo $bundle['name'] . "\n";

    $version = $bundle['version'];
    $success = $bundle->update($id, 'updated-name-' . rand(0,500), '', $version);

    if ($success) {
        $bundle = $bundle->load($item['href']);
        $id = $bundle['_links']['self']['href'];
        echo $id . "\n";
        echo $bundle['name'] . "\n";
    } else {
        echo "Nope, it didn't update \n";
    }
}
