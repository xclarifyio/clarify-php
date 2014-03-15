<?php

namespace Op3nvoice;

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
        if($ob === null) {
// todo: throw exception for invalid json?
        }
        if (!in_array($media_channel, array('left', 'right', 'split'))) {
// todo: throw exception for invalid enum type?
        }

        $request = $this->client->post('/v1/audio', array(), '', array('exceptions' => false));
        $request->addHeader('Authorization', $this->apiKey);
        $request->setPostField('name', $name);
        $request->setPostField('media_url', $media_url);
        $request->setPostField('notify_url', $notify_url);
        $request->setPostField('media_channel', $media_channel);
        $request->setPostField('metadata', $metadata);
        $response = $request->send();

//todo: we should probably get the Location header for this one too
        $this->detail = $response->json();

        return $response->isSuccessful();
    }

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

    public function load($id)
    {
        $request = $this->client->get($id, array(), array('exceptions' => false));
        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();

        return $response->json();
    }

    public function delete($id)
    {
        $request = $this->client->delete($id, array(), '', array('exceptions' => false));
        $response = $request->send();
        $this->detail = $response->json();

        return $response->isSuccessful();
    }
}