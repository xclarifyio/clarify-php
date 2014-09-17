<?php

namespace Clarify;
use Clarify\Exceptions\InvalidEnumTypeException;
use Clarify\Exceptions\InvalidJSONException;

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

        $audio_channel = isset($options['audio_channel']) ? $options['audio_channel'] : '';
        if (!in_array($audio_channel, array('left', 'right', 'split', ''))) {
            throw new InvalidEnumTypeException();
        }

        $result = $this->client->post('bundles', $params);
        $this->detail = $this->client->detail;

        return $result;
    }

    /**
     * @param $id
     * @param string $name
     * @param string $notify_url
     * @param int $version
     * @return mixed
     */
    public function update($id, $name = '', $notify_url = '', $version  = 1)
    {
        $params = array();
        $params['id'] = $id;
        $params['name'] = $name;
        $params['notify_url'] = $notify_url;
        $params['version'] = $version;

        return $this->client->put($params);
    }

    public function delete($id)
    {
        return $this->client->delete($id);
    }

    public function load($id)
    {
        return $this->client->get($id);
    }

    public function index($limit = 10, $embed = '', $iterator = '')
    {
        $params = array('limit' => $limit, 'embed' => $embed, 'iterator' => $iterator);
        $this->detail = $this->client->get('bundles', $params);

        return $this->detail;
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
        $params = array('query' => $query, 'limit' => $limit, 'embed' => $embed, 'iterator' => $iterator);
        $this->detail = $this->client->get('search', $params);

        return $this->detail;
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
        switch ($name) {
            case 'tracks':
                return new Tracks($this->client);
            case 'metadata':
                return new Metadata($this->client);
            default:
                throw new \Clarify\Exceptions\InvalidResourceException('Not supported');
        }
    }
}