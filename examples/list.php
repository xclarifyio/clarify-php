<?php

// Don't forget to rename credentials-dist.php to credentials.php and insert your API key
require __DIR__ . '/credentials.php';
require __DIR__.'/../vendor/autoload.php';

$bundle = new \Clarify\Bundle($apikey);
$bundle->index();

foreach ($bundle as $bundle_id) {
    $_bundle = $bundle->load($bundle_id);

    echo $_bundle['_links']['self']['href'] . "\n";
    echo $_bundle['name'] . "\n";
}
