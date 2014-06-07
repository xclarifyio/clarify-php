<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$audio = new \OP3Nvoice\Bundle($apikey);

$items = $audio->index();

$item = $items[0];

echo $item['href'] . "\n";

$item = $audio->delete($item['href']);
$bundle = $audio->load($item['href']);

print_r($bundle);
