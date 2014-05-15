<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new OP3Nvoice\Bundle($apikey);

$items = $audio->index();

$item = $items[0];

echo $item['href'] . "\n";

$item = $audio->delete($item['href']);
$bundle = $audio->load($item['href']);

print_r($bundle);