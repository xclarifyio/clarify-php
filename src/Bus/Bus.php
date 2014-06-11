<?php

namespace OP3Nvoice\Bus;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;

class Bus
{
    protected $client;

    public function __construct()
    {
        $spec = new OP3NvoiceSpec();
        $apiBaseUrl = 'https://api-beta.OP3Nvoice.com/v1/';
        $description = new Description($spec->getDescription($apiBaseUrl));
        $this->client = new GuzzleClient(
            new HttpClient(),
            $description
        );
    }

    public function getClient()
    {
        return $this->client;
    }
}