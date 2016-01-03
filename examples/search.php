<?php

// Don't forget to rename credentials-dist.php to credentials.php and insert your API key
require __DIR__ . '/credentials.php';
require __DIR__.'/../vendor/autoload.php';

$bundle = new \Clarify\Bundle($apikey);

$page = $bundle->search('dorothy');

$results = $page['item_results'];
$items = $page['_links']['items'];
foreach ($items as $index => $item) {
    $_bundle = $bundle->load($item['href']);

    echo $_bundle['_links']['self']['href'] . "\n";
    echo $_bundle['name'] . "\n";

    $search_hits = $results[$index]['term_results'][0]['matches'][0]['hits'];
    foreach ($search_hits as $search_hit) {
        echo $search_hit['start'] . ' -- ' . $search_hit['end'] . "\n";
    }
}