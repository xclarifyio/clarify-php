<?php

namespace Clarify;
use Clarify\Exceptions\InvalidEnumTypeException;
use Clarify\Exceptions\InvalidJSONException;
use Clarify\Exceptions\InvalidIntegerArgumentException;

/**
 * Class Bundle
 * @package Clarify
 *
 * @property mixed  $metadata   This is the metadata subresource of the bundle.
 * @property mixed  $tracks     This is the tracks subresource of the bundle.
 */
class Bundle
{
    protected $client = null;
    public $detail = null;
    public $location = null;

    public function __construct($key, $client = null)
    {
        $this->client = (is_null($client)) ? new \Clarify\Client($key) : $client;
    }

    /**
     * @param string $name
     * @param string $media_url
     * @param string $metadata
     * @param string $notify_url
     * @param string $audio_channel
     * @return bool
     * @throws Exceptions\InvalidJSONException
     * @throws Exceptions\InvalidEnumTypeException
     */
    public function create($name = '', $media_url = '', $metadata = '', $notify_url = '', $audio_channel = '')
    {
        $params = array();
        $params['name'] = $name;
        $params['media_url'] = $media_url;
        $params['metadata'] = $metadata;
        $params['notify_url'] = $notify_url;
        $params['audio_channel'] = $audio_channel;

        $ob = json_decode($metadata);
        if ($metadata != '' && $ob === null) {
            throw new InvalidJSONException();
        }

        $audio_channel = isset($params['audio_channel']) ? $params['audio_channel'] : '';
        if (!in_array($audio_channel, array('left', 'right', 'split', ''))) {
            throw new InvalidEnumTypeException();
        }

        $result = $this->client->post('bundles', $params);
        $this->detail = $this->client->detail;
        $this->location = $this->client->response->getHeader('Location');

        return $result;
    }

    /**
     * @param $id
     * @param string $name
     * @param string $notify_url
     * @param int $version
     * @return mixed
     * @throws InvalidIntegerArgumentException
     */
    public function update($id, $name = '', $notify_url = '', $version  = 1)
    {
        $params = array();
        $params['name'] = $name;
        $params['notify_url'] = $notify_url;
        $params['version'] = $version;
        if (!is_numeric($params['version'])) {
            throw new InvalidIntegerArgumentException();
        }

        return $this->client->put($id, $params);
    }

    public function delete($id)
    {
        return $this->client->delete($id);
    }

    public function load($id)
    {
        return $this->client->get($id);
    }

    public function index($limit = 10, $embed = '')
    {
        $params = array('limit' => $limit, 'embed' => $embed);
        $this->detail = $this->client->get('bundles', $params);

        return $this->detail;
    }

    public function search($query, $limit = 10, $embed = '')
    {
        $params = array('query' => $query, 'limit' => $limit, 'embed' => $embed);
        $this->detail = $this->client->get('search', $params);

        return $this->detail;
    }

    public function hasMorePages()
    {
        return isset($this->detail['_links']['next']);
    }

    public function getNextPage()
    {
        $next = $this->detail['_links']['next']['href'];
        $this->detail = $this->client->get($next);

        return $this->detail;
    }

    public function getPreviousPage()
    {
        $previous = $this->detail['_links']['prev']['href'];
        $this->detail = $this->client->get($previous);

        return $this->detail;
    }

    public function getResponse()
    {
        return $this->client->response;
    }

    public function getStatusCode()
    {
        return $this->client->statusCode;
    }

    /**
     * @param $name
     * @return Metadata|Tracks
     * @throws Exceptions\InvalidResourceException
     */
    public function __get($name)
    {
        $classname = ucwords($name);
        $fullclass = "Clarify\\" . $classname;

        if (class_exists($fullclass)) {
            return new $fullclass($this->client);
        }

        throw new \Clarify\Exceptions\InvalidResourceException('Not supported');
    }
}