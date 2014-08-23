<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$bundle = new \Clarify\Bundle($apikey);

$result = $bundle->search('strong');

$results = $result['item_results'];
$items = $result['_links']['items'];
foreach ($items as $index => $item) {
    $bundle = $bundle->load($item['href']);

    echo $bundle['_links']['self']['href'] . "\n";
    echo $bundle['name'] . "\n";

    $search_hits = $results[$index]['term_results'][0]['matches'][0]['hits'];
    foreach ($search_hits as $search_hit) {
        echo $search_hit['start'] . ' -- ' . $search_hit['end'] . "\n";
    }
}
