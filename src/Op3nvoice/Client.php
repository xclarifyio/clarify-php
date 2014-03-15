<?php

namespace Op3nvoice;

use Guzzle\Http;

class Client
{
    const USER_AGENT = 'op3nvoice-php/0.0.1';

    protected $client  = null;
    protected $request = null;
    protected $response = null;
    protected $baseURI = 'https://api-beta.op3nvoice.com/v1';

    public function __construct($key)
    {
        $this->client = new Http\Client($this->baseURI);
        $this->client->setUserAgent($this::USER_AGENT . '/' . PHP_VERSION);

        $this->request = $this->client->get('/');
        $this->request->addHeader('Authorization', $key);
    }

    public function authenticate()
    {
        $this->response =  $this->request->send();

        return $this->response->isSuccessful();
    }
}