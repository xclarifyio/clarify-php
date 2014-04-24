<?php

namespace OP3Nvoice;

use OP3Nvoice\Exceptions\InvalidJSONException;

class Tracks extends Client
{
    protected function getTrackURI($id)
    {
        $request = $this->client->get($id, array(), array('exceptions' => false));
        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $bundle = $response->json();
        $trackURI = $bundle['_links']['o3v:tracks']['href'];

        return $trackURI;
    }

    public function load($id)
    {
        $trackURI = $this->getTrackURI($id);

        $request = $this->client->get($trackURI, array(), array('exceptions' => false));
        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->json();
    }

    public function update($id, $track = 0, $label ='', $media_url = '', $audio_channel = '', $source = '', $version = '')
    {
        $trackURI = $this->getTrackURI($id);

        $request = $this->client->put($trackURI, array(), '', array('exceptions' => false));
        $request->setPostField('track', $track);
        $request->setPostField('label', $label);
        $request->setPostField('media_url', $media_url);
        $request->setPostField('audio_channel', $audio_channel);
        $request->setPostField('source', $source);
        $request->setPostField('version', $version);

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->isSuccessful();
    }

    public function delete($id)
    {
        $trackURI = $this->getTrackURI($id);

        $request = $this->client->delete($trackURI, array(), '', array('exceptions' => false));

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->isSuccessful();
    }
}