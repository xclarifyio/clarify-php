<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new Op3nvoice\Audio($apikey);

$bundle = $audio->load('/v1/audio/92e3b7389982495d85f495a33bd82fb7');

print_r($bundle);