<?php

// Don't forget to rename credentials-dist.php to credentials.php and insert your API key
require __DIR__ . '/credentials.php';
require __DIR__.'/../vendor/autoload.php';

$bundle = new \Clarify\Bundle($apikey);

$results = $bundle->index();
$items = $results['_links']['items'];

foreach ($items as $item) {
    $_bundle = $bundle->load($item['href']);

    $id = $_bundle['_links']['self']['href'];
    echo $id . "\n";
    echo $_bundle['name'] . "\n";

    $version = $_bundle['version'];
    $success = $bundle->update($id, 'updated-name-' . rand(0,500), '', $version);

    if ($success) {
        $_bundle = $bundle->load($item['href']);
        $id = $_bundle['_links']['self']['href'];
        echo $id . "\n";
        echo $_bundle['name'] . "\n";
    } else {
        echo "Nope, it didn't update \n";
    }
    echo "\n\n";
}
