<?php

// Don't forget to rename creds-dist.php to creds.php and insert your API key
require __DIR__.'/creds.php';
require __DIR__.'/../vendor/autoload.php';

$bundle = new \Clarify\Bundle($apikey);

$items = $bundle->index();

foreach ($items as $item) {
    $tracks = $bundle->tracks;
    $data = $tracks->load($item['href']);
    print_r($data);

    $tracks->update(
        array(
            'id' => $item['href'],
            'track' => 2,
            'label' => "an awesome label",
        )
    );
    $data = $tracks->load($item['href']);
    print_r($data);
}
