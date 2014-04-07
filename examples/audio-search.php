<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new Op3nvoice\Audio($apikey);

$result = $audio->search('close');

$results = $result['item_results'];
$items = $result['_links']['item'];
foreach($items as $index => $item) {
    $bundle = $audio->load($item['href']);

    echo $bundle['_links']['self']['href'] . "\n";
    echo $bundle['name'] . "\n";

    $search_hits = $results[$index]['term_results'][0]['matches'][0]['hits'];
    foreach($search_hits as $search_hit) {
        echo $search_hit['start'] . ' -- ' . $search_hit['end'] . "\n";
    }
}