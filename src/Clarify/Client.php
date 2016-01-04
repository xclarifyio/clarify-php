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
    const USER_AGENT = 'clarify-php/2.0.0';

    protected $baseURI  = 'https://api.clarify.io/v1/';
    protected $apiKey   = '';
    protected $client   = null;
    protected $request  = null;
    public $response = null;
    public $statusCode = null;
    public $detail   = null;

    /**
     * @param $key
     * @param null $httpClient
     */
    public function __construct($key, $httpClient = null)
    {
        $this->apiKey = $key;
        $this->httpClient = (is_null($httpClient)) ? new GuzzleClient(
            ['base_uri' => $this->baseURI, 'headers' => ['User-Agent' => $this::USER_AGENT . '/' . PHP_VERSION ]]
        ) : $httpClient;
    }

    /**
     * @param $request
     * @return Http\Message\Response|null
     */
    protected function process($request)
    {
        $request->setHeader('Authorization', 'Bearer ' . $this->apiKey);
        $this->response =  $request->send();
        $this->statusCode = $this->response->getStatusCode();
        $this->detail = $this->response->json();

        return $this->response->isSuccessful();
    }

    /**
     * @param $uri
     * @param array $options
     * @return Http\Message\Response|null
     */
    public function post($uri, array $options = array())
    {
        $successful = false;

        $this->response = $this->httpClient->post($uri,
            ['http_errors' => false, 'form_params' => $options, 'headers' => ['Authorization' => 'Bearer ' . $this->apiKey ] ]
        );
        $this->statusCode = $this->response->getStatusCode();
        $this->detail = json_decode($this->response->getBody(), true);

        if (2 == substr($this->statusCode, 0, 1)) {
            $successful = true;
        }

        return $successful;
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

        $request = $this->client->put($uri, array(), '', array('exceptions' => false));
        unset($options['id']);
        foreach($options as $key => $value) {
            $request->setPostField($key, $value);
        }

        return $this->process($request);
    }

    /**
     * @param $uri
     * @param array $parameters
     * @return array|bool|float|int|string
     */
    public function get($uri, array $parameters = array())
    {
        $this->response = $this->httpClient->get($uri,
            ['http_errors' => false, 'query' => $parameters, 'headers' => ['Authorization' => 'Bearer ' . $this->apiKey ] ]
        );
        $this->statusCode = $this->response->getStatusCode();
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
        $successful = false;

        $this->response = $this->httpClient->delete($uri,
            ['http_errors' => false, 'headers' => ['Authorization' => 'Bearer ' . $this->apiKey ] ]
        );
        $this->statusCode = $this->response->getStatusCode();
        $this->detail = json_decode($this->response->getBody(), true);

        if (2 == substr($this->statusCode, 0, 1)) {
            $successful = true;
        }

        return $successful;
    }
}
