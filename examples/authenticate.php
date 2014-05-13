<?php

require 'creds.php';
require '../vendor/autoload.php';

$audio = new OP3Nvoice\Bundle($apikey);

$audio->authenticate();

echo $audio->getStatusCode();

echo "\n\n";