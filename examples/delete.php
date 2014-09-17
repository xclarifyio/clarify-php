<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$bundle = new \Clarify\Bundle($apikey);

$results = $bundle->index();
$item = $results['_links']['items'][0];

echo $item['href'] . "\n";

$bundle->delete($item['href']);
$bundle->load($item['href']);

echo $bundle->getStatusCode() . "\n";
