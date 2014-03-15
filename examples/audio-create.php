<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new Op3nvoice\Audio($apikey);

$success = $audio->create('http://example.com/');

if ($success) {
    echo $audio->detail['_links']['self']['href'] . "\n";
} else {
    echo $audio->detail['message'] . "\n";
}