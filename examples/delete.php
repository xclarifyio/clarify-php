<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$bundle = new \Clarify\Bundle($apikey);

$items = $bundle->index();

$item = $items[0];

echo $item['href'] . "\n";

$item = $bundle->delete($item['href']);
$bundle = $bundle->load($item['href']);

print_r($bundle);
