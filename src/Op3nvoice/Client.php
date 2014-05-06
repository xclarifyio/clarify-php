<?php

namespace OP3Nvoice;

use Guzzle\Http;

/**
 * Class Client
 * @package OP3Nvoice
 *
 * This is the base class that all of the individual media-related classes extend. At the moment, it simply initializes
 *   the connection by setting the user agent and the base URI for the API calls.
 */
abstract class Client
{
    const USER_AGENT = 'op3nvoice-php/0.7.0';

    protected $apiKey   = '';
    protected $client   = null;
    protected $request  = null;
    protected $response = null;
    protected $baseURI  = 'https://api-beta.OP3Nvoice.com/v1';

    protected $detail   = null;
    /**
     * @param $key
     */
    public function __construct($key)
    {
        $this->apiKey = $key;
        $this->client = new Http\Client($this->baseURI);
        $this->client->setUserAgent($this::USER_AGENT . '/' . PHP_VERSION);
    }

    /**
     * @return bool
     */
    public function authenticate()
    {
        $request = $this->client->get('/');
        $request->addHeader('Authorization', $this->apiKey);
        $this->response =  $request->send();

        return $this->response->isSuccessful();
    }

    /**
     * @param $name
     * @return Metadata|Tracks
     * @throws InvalidResourceException
     */
    public function __get($name)
    {
        switch ($name) {
            case 'tracks':
                return new Tracks($this->apiKey);
            case 'metadata':
                return new Metadata($this->apiKey);
                break;
            default:
                throw new InvalidResourceException();
        }
    }
}