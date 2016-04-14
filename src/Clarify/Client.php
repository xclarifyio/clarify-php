<?php

namespace Clarify;

use GuzzleHttp\Client as GuzzleClient;
use Clarify\Exceptions\InvalidIntegerArgumentException;


/**
 * This is the base class that all of the individual media-related classes extend. At the moment, it simply initializes
 *   the connection by setting the user agent and the base URI for the API calls.
 *
 * Class Client
 * @package Clarify
 *
 * @property mixed  stores      This is the stores subresource of the client.
 * @property mixed  products    This is the products subresource of the client.
 */
class Client
{
    const USER_AGENT = 'clarify-php';
    const VERSION = '2.1.0';

    protected $baseURI  = 'https://api.clarify.io/v1/';
    protected $apiKey   = '';
    protected $client   = null;
    protected $request  = null;
    public $response    = null;
    public $statusCode  = null;
    public $raw         = null; // This is the raw response body. It's unlikely you'll need it but just in case.
    public $detail      = null; // This is the json decoded response. This is probably what you want.


    /**
     * @param $key
     * @param null $httpClient
     * @param string $user_agent    only used if you need a custom/unique user agent
     */
    public function __construct($key, $httpClient = null, $user_agent = '')
    {
        $this->apiKey = $key;
        $_agent = ('' == $user_agent) ? $this::USER_AGENT : $user_agent;
        $this->client = (is_null($httpClient)) ? new GuzzleClient(
            ['base_uri' => $this->baseURI, 'headers' => ['User-Agent' => $_agent . '/' . $this::VERSION . '/' . PHP_VERSION ]]
        ) : $httpClient;
    }

    /**
     * @param $uri
     * @param array $options
     * @return bool
     */
    public function post($uri, array $options = array())
    {
        $this->process('POST', $uri, ['form_params' => $options]);
        $this->detail = json_decode($this->response->getBody(), true);

        return $this->isSuccessful();
    }

    /**
     * @param $uri
     * @param array $options
     * @return bool
     * @throws Exceptions\InvalidIntegerArgumentException
     */
    public function put($uri, array $options)
    {
        $version = isset($options['version']) ? $options['version'] : '1';
        if (!is_numeric($version)) {
            throw new InvalidIntegerArgumentException();
        }

        unset($options['id']);
        $this->process('PUT', $uri, ['form_params' => $options]);
        $this->detail = json_decode($this->response->getBody(), true);

        return $this->isSuccessful();
    }

    /**
     * @param $uri
     * @param array $parameters
     * @return array|bool|float|int|string
     */
    public function get($uri, array $parameters = array())
    {
        $options = array();
        $options['query'] = $parameters;

        $this->process('GET', $uri, $options);
        $this->detail = json_decode($this->response->getBody(), true);

        return $this->detail;
    }

    /**
     * This deletes a resource using a full URI.
     *
     * @param $uri
     * @return bool
     */
    public function delete($uri)
    {
        return $this->process('DELETE', $uri);
    }

    /**
     * @param $method
     * @param $uri
     * @param array $options
     * @return mixed
     */
    protected function process($method, $uri, $options = array())
    {
        $options['http_errors'] = 'false';
        $options['headers']     = ['Authorization' => 'Bearer ' . $this->apiKey ];

        $this->response = $this->client->request($method, $uri, $options);
        $this->statusCode = $this->response->getStatusCode();
        $this->raw = $this->response->getBody();

        return $this->isSuccessful();
    }

    protected function isSuccessful()
    {
        $successful = false;

        if (2 == substr($this->statusCode, 0, 1)) {
            $successful = true;
        }

        return $successful;
    }
}
