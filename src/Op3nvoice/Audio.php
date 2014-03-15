<?php

namespace Op3nvoice;

class Audio extends Client
{
    public $detail = null;

    /**
     * @param string $media_url
     * @param string $name
     * @param string $notify_url
     * @param string $media_channel
     * @param string $metadata
     * @return bool
     */
    public function create($media_url = '', $name = '', $notify_url = '', $media_channel = 'split', $metadata = '')
    {
        $ob = json_decode($metadata);
        if($ob === null) {
            // todo: throw exception for invalid json?
        }
        if (!in_array($media_channel, array('left', 'right', 'split'))) {
            // todo: throw exception for invalid enum type?
        }

        $request = $this->client->post($this->baseURI . '/audio', array(), '', array('exceptions' => false));
        $request->addHeader('Authorization', $this->apiKey);
        $request->setPostField('name', $name);
        $request->setPostField('media_url', $media_url);
        $request->setPostField('notify_url', $notify_url);
        $request->setPostField('media_channel', $media_channel);
        $request->setPostField('metadata', $metadata);
        $response = $request->send();

        $this->detail = $response->json();

        return $response->isSuccessful();
    }
}