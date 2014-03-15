<?php

require 'creds.php';
require '../vendor/autoload.php';

$client = new Op3nvoice\Client($apikey);
$result = $client->authenticate();

if ($result) {
    echo "It worked! \n";
} else {
    echo "Nope, it failed \n";
}