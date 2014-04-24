<?php

namespace OP3Nvoice;

class Tracks extends Subresource
{
    protected $subresource = 'o3v:tracks';

    /**
     * @param $id
     * @param int $track
     * @param string $label
     * @param string $media_url
     * @param string $audio_channel
     * @param string $source
     * @param string $version
     * @return bool
     */
    public function update($id, $track = 0, $label ='', $media_url = '', $audio_channel = '', $source = '', $version = '')
    {
        $resourceURI = $this->getSubresourceURI($id);

        $request = $this->client->put($resourceURI, array(), '', array('exceptions' => false));
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

    /**
     * @param $id
     * @param $media_url
     * @param string $label
     * @param string $audio_channel
     * @param string $source
     * @return bool
     */
    public function create($id, $media_url, $label = '', $audio_channel = '', $source = '')
    {
        $resourceURI = $this->getSubresourceURI($id);

        $request = $this->client->post($resourceURI, array(), '', array('exceptions' => false));
        $request->setPostField('media_url', $media_url);
        $request->setPostField('label', $label);
        $request->setPostField('audio_channel', $audio_channel);
        $request->setPostField('source', $source);

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->isSuccessful();
    }
}