<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new Op3nvoice\Audio($apikey);

$bundles = $audio->index();

foreach($bundles as $bundle) {
    echo $bundle['href'] . "\n";
}