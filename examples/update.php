<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$audio = new \OP3Nvoice\Bundle($apikey);

$items = $audio->index();

foreach ($items as $item) {
    $bundle = $audio->load($item['href']);

    $id = $bundle['_links']['self']['href'];
    echo $id . "\n";
    echo $bundle['name'] . "\n";

    $success = $audio->update(
        array(
            'id' => $id,
            'name' => 'updated-name-' . rand(0,500),
        )
    );

    if ($success) {
        $bundle = $audio->load($item['href']);
        $id = $bundle['_links']['self']['href'];
        echo $id . "\n";
        echo $bundle['name'] . "\n";
    } else {
        echo "Nope, it didn't update \n";
    }
}