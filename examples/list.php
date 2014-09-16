<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$bundle = new \Clarify\Bundle($apikey);

$results = $bundle->index();
$items = $results['_links']['items'];

foreach ($items as $item) {
    $_bundle = $bundle->load($item['href']);

    echo $_bundle['_links']['self']['href'] . "\n";
    echo $_bundle['name'] . "\n";
}

$page = $bundle->getNextPage();
print_r($page);
