<?php

namespace OP3Nvoice\Bus;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Subscriber\Log\LogSubscriber;

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
        $description = new Description($spec->getDescription($apiBaseUrl));
        $httpClient = new HttpClient($config);
        $httpClient->getEmitter()->attach(new LogSubscriber());
        $httpClient->getEmitter()->attach(new AuthenticatorSubscriber($apiKey));
        $this->client = new GuzzleClient(
            $httpClient,
            $description,
            []
        );
    }

    public function getClient()
    {
        return $this->client;
    }
}