<?php

namespace Clarify;

use Guzzle\Http;
use Clarify\Metadata;
use Clarify\Tracks;
use Clarify\Exceptions\InvalidJSONException;
use Clarify\Exceptions\InvalidResourceException;
use Clarify\Exceptions\InvalidEnumTypeException;
use Clarify\Exceptions\InvalidIntegerArgumentException;


/**
 * This is the base class that all of the individual media-related classes extend. At the moment, it simply initializes
 *   the connection by setting the user agent and the base URI for the API calls.
 */
abstract class Client
{
    const USER_AGENT = 'op3nvoice-php/0.9.1';

    protected $baseURI  = 'https://api-beta.OP3Nvoice.com/v1/';
    protected $apiKey   = '';
    protected $client   = null;

    /**
     * @var $response \Guzzle\Http\Message\Request
     */
    protected $request  = null;

    /**
     * @var $response \Guzzle\Http\Message\Response
     */
    protected $response = null;
    protected $statusCode = null;
    public $detail   = null;

    /**
     * @param $key
     */
    public function __construct($key)
    {
        $this->apiKey = $key;
        $this->client = new Http\Client($this->baseURI);
        $this->client->setUserAgent($this::USER_AGENT . '/' . PHP_VERSION);
    }

    protected function process($request)
    {
        $request->setHeader('Authorization', 'Bearer ' . $this->apiKey);
        $this->response =  $request->send();
        $this->statusCode = $this->response->getStatusCode();

        return $this->response;
    }

    /**
     * The response and status code are immutable so we have them as a protected properties with a getter.
     *
     * @return null
     */
    public function getResponse()
    {
        return $this->response;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
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
            default:
                throw new InvalidResourceException('Not supported');
        }
    }

    /**
     * @param array $options
     * @throws Exceptions\InvalidEnumTypeException
     * @throws Exceptions\InvalidJSONException
     * @return bool
     */
    public function post(array $options)
    {
        $metadata = isset($options['metadata']) ? $options['metadata'] : '';
        $ob = json_decode($metadata);
        if ($metadata != '' && $ob === null) {
            throw new InvalidJSONException();
        }

        $audio_channel = isset($options['audio_channel']) ? $options['audio_channel'] : '';
        if (!in_array($audio_channel, array('left', 'right', 'split', ''))) {
            throw new InvalidEnumTypeException();
        }

        /** @var $request \Guzzle\Http\Message\Request */
        $request = $this->client->post('bundles', array(), '', array('exceptions' => false));
        foreach($options as $key => $value) {
            $request->setPostField($key, $value);
        }

        $response = $this->process($request);
        $this->detail = $response->json();

        return array(
            'code' => $response->getStatusCode(),
            'location_header' => $response->getHeader('Location'),
        );
    }

    /**
     * @param array $options
     * @throws Exceptions\InvalidIntegerArgumentException
     * @return mixed
     */
    public function put(array $options)
    {
        $version = isset($options['version']) ? $options['version'] : '1';
        if (!is_numeric($version)) {
            throw new InvalidIntegerArgumentException();
        }

        $request = $this->client->put($options['id'], array(), '', array('exceptions' => false));
        foreach($options as $key => $value) {
            $request->setPostField($key, $value);
        }

        $response = $this->process($request);
        $this->detail = $response->json();

        return $response->isSuccessful();
    }

    /**
     * @param int $limit
     * @param string $embed
     * @param string $iterator
     * @return array
     */
    public function index($limit = 10, $embed = '', $iterator = '' )
    {
        $items = array();

        $request = $this->client->get('bundles', array(), array('exceptions' => false));
        $request->getQuery()->set('limit', $limit);
        $request->getQuery()->set('embed', $embed);
        $request->getQuery()->set('iterator', $iterator);

        $response = $this->process($request);

        $this->detail = $response->json();
//todo: add information about pagination
        if ($response->isSuccessful()) {
            $items = $this->detail['_links']['items'];
        }

        return $items;
    }

    /**
     * This loads an audio bundle using a full URI
     * @param $id
     * @return array|bool|float|int|string
     */
    public function load($id)
    {
        $request = $this->client->get($id, array(), array('exceptions' => false));
        $response = $this->process($request);

        $this->detail = $response->json();

        return $response->json();
    }

    /**
     * This deletes an audio bundle using a full URI.
     *
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $request = $this->client->delete($id, array(), '', array('exceptions' => false));
        $response = $this->process($request);

        $this->detail = $response->json();

        return $response->isSuccessful();
    }

    /**
     * @param $query
     * @param int $limit
     * @param string $embed
     * @param string $iterator
     * @return array|bool|float|int|string
     */
    public function search($query, $limit = 10, $embed = '', $iterator = '')
    {
        $search = new Search($this->apiKey);

        return $search->search($query, $limit, $embed, $iterator);
    }
}
