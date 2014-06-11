<?php

namespace OP3Nvoice\Bus;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;

class Bus
{
    protected $client;

    public function __construct($apiKey)
    {
        $config = [
            'defaults' => [
                'headers' => ['Bearer' => $apiKey]
            ],
        ];

        $spec = new OP3NvoiceSpec();
        $apiBaseUrl = 'https://api-beta.OP3Nvoice.com/v1/';
        $httpClient = new HttpClient($config);

        // attach logger to see what is happening
        //$httpClient->getEmitter()->attach();

        $description = new Description($spec->getDescription($apiBaseUrl));
        $this->client = new GuzzleClient(
            $httpClient,
            $description,
            []
        );
        $this->client->getEmitter()
    }

    public function getClient()
    {
        return $this->client;
    }
}