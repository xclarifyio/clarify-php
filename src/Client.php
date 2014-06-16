<?php

namespace OP3Nvoice;

use Guzzle\Http;
use OP3Nvoice\Exceptions\InvalidEnumTypeException;
use OP3Nvoice\Exceptions\InvalidIntegerArgumentException;
use OP3Nvoice\Metadata;
use OP3Nvoice\Tracks;
use OP3Nvoice\Exceptions\InvalidJSONException;
use OP3Nvoice\Exceptions\InvalidResourceException;

/**
 * This is the base class that all of the individual media-related classes extend. At the moment, it simply initializes
 *   the connection by setting the user agent and the base URI for the API calls.
 */
abstract class Client
{
    const USER_AGENT = 'op3nvoice-php/0.9.0';

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
    protected $baseURI  = 'https://api-beta.OP3Nvoice.com/v1/';

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
    public function create(array $options)
    {
        $metadata = isset($options['metadata']) ? $options['metadata'] : '';
        $audio_channel = isset($options['audio_channel']) ? $options['audio_channel'] : '';
        $name = isset($options['name']) ? $options['name'] : '';
        $media_url = isset($options['media_url']) ? $options['media_url'] : '';
        $notify_url = isset($options['notify_url']) ? $options['notify_url'] : '';

        $ob = json_decode($metadata);
        if ($metadata != '' && $ob === null) {
            throw new InvalidJSONException();
        }
        if (!in_array($audio_channel, array('left', 'right', 'split'))) {
            throw new InvalidEnumTypeException();
        }

        /** @var $request \Guzzle\Http\Message\Request */
        $request = $this->client->post('bundles', array(), '', array('exceptions' => false));
        $request->setPostField('name', $name);
        $request->setPostField('media_url', $media_url);
        $request->setPostField('notify_url', $notify_url);
        $request->setPostField('audio_channel', $audio_channel);
        $request->setPostField('metadata', $metadata);

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
    public function update(array $options)
    {
        $name = isset($options['name']) ? $options['name'] : '';
        $notify_url = isset($options['notify_url']) ? $options['notify_url'] : '';
        $version = isset($options['version']) ? $options['version'] : '1';
        if (!is_numeric($version)) {
            throw new InvalidIntegerArgumentException();
        }

        $request = $this->client->put($options['id'], array(), '', array('exceptions' => false));
        $request->setPostField('name', $name);
        $request->setPostField('notify_url', $notify_url);
        $request->setPostField('version', $version);

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
