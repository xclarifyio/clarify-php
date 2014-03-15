<?php

namespace Op3nvoice;

class Audio
{
    protected $client = null;

    public function __construct($client)
    {
        $this->client = $client;
    }

    public function index()
    {
        $this->client->request->get('audio');
        $this->client->process();

        return array();
    }
}