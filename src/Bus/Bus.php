<?php

namespace OP3Nvoice\Bus;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;

class Bus
{
    protected $client;

    public function __construct($apikey)
    {
        // use $apikey which is the Oauth2.0 bearer token
        // to initialize the client configuration via
        // a setting Bearer header subscriber

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