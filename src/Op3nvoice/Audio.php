<?php

namespace Op3nvoice;

use Op3nvoice\Exceptions\InvalidJSONException;

class Audio extends Client
{
    public $detail = null;

    /**
     * @param string $media_url     The url where your audio file is available, valid filetypes are [Todo: list these]
     * @param string $name          A human readable name for this bundle
     * @param string $notify_url    A callback which we will post to when processing this bundle is complete
     * @param string $media_channel Whether this is stereo or mono. Valid values are: left, right, split or an empty string
     * @param string $metadata      A JSON formatted string with additional information about this bundle
     * @return bool
     */
    public function create($media_url = '', $name = '', $notify_url = '', $media_channel = '', $metadata = '')
    {
        $ob = json_decode($metadata);
        if($metadata != '' && $ob === null) {
            throw new InvalidJSONException();
        }
        if (!in_array($media_channel, array('left', 'right', 'split'))) {
// todo: throw exception for invalid enum type?
        }

        $request = $this->client->post('/v1/audio', array(), '', array('exceptions' => false));
        $request->setPostField('name', $name);
        $request->setPostField('media_url', $media_url);
        $request->setPostField('notify_url', $notify_url);
        $request->setPostField('audio_channel', $media_channel);
        $request->setPostField('metadata', $metadata);

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

//todo: we should probably get the Location header for this one too

        return $response->isSuccessful();
    }

    public function update($id, $name = '', $notify_url = '', $version = 0)
    {
        if (!is_numeric($version)) {
// todo: throw exception for not being a number?
        }

        $request = $this->client->put($id, array(), '', array('exceptions' => false));
        $request->setPostField('name', $name);
        $request->setPostField('notify_url', $notify_url);
        $request->setPostField('version', $version);

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->isSuccessful();
    }

    /**
     * @return array
     */
    public function index()
    {
        $items = array();

        $request = $this->client->get('/v1/audio', array(), array('exceptions' => false));

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

//todo: add information about pagination
        if ($response->isSuccessful()) {
            $items = $this->detail['_links']['item'];
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

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->json();
    }

    public function tracks($id)
    {
        $request = $this->client->get($id . '/tracks', array(), array('exceptions' => false));

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->json();
    }

    public function bundles($id)
    {
        $request = $this->client->get($id . '/bundles', array(), array('exceptions' => false));

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
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

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->isSuccessful();
    }

    public function search($query, $limit = 10, $embed = '', $iterator = '')
    {
        $search = new Search($this->apiKey);

        return $search->search($query, $limit, $embed, $iterator);
    }
}