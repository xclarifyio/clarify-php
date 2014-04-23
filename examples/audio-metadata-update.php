<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new OP3Nvoice\Audio($apikey);

$items = $audio->index();

foreach($items as $item) {
    $success = $audio->metadata->update($item['href'], '{"op3nvoice":true}');
}