<?php

require 'creds.php';
require '../vendor/autoload.php';

$client = new Op3nvoice\Client($apikey);

$bundles = $client->audio->create();

foreach($bundles as $bundle) {
    echo $bundle['name'] . "\n";
}



//include_once '../creds.php';
//include_once '../Services/Marvel.php';
//
//$client = new Services_Marvel($public_key, $private_key);
//$characters = $client->characters->index(3, 25);
//
//foreach ($characters as $character) {
//    echo $character->name . "\n";
//}
