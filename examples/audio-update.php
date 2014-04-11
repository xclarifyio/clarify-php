<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new OP3Nvoice\Audio($apikey);

$items = $audio->index();

foreach($items as $item) {
    $bundle = $audio->load($item['href']);

    $id = $bundle['_links']['self']['href'];
    echo $id . "\n";
    echo $bundle['name'] . "\n";

    $success = $audio->update($id, 'updated-name-' . rand(0,500));

    if ($success) {
        $bundle = $audio->load($item['href']);
        $id = $bundle['_links']['self']['href'];
        echo $id . "\n";
        echo $bundle['name'] . "\n";
    } else {
        echo "Nope, it didn't update \n";
    }
}