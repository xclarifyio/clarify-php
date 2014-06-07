<?php

namespace OP3Nvoice;

class Tracks extends Subresource
{
    protected $subresource = 'o3v:tracks';

    /**
     * @param  array $options
     * @return bool
     */
    public function update(array $options)
    {
        $resourceURI = $this->getSubresourceURI($options['id']);

        $request = $this->client->put($resourceURI, array(), '', array('exceptions' => false));
        $request->setPostField('track', isset($options['track']) ? $options['track'] : 0);
        $request->setPostField('label', isset($options['label']) ? $options['label'] : '');
        $request->setPostField('media_url', isset($options['media_url']) ? $options['media_url'] : '');
        $request->setPostField('audio_channel', isset($options['audio_channel']) ? $options['audio_channel'] : '');
        $request->setPostField('source', isset($options['source']) ? $options['source'] : '');
        $request->setPostField('version', isset($options['version']) ? $options['version'] : '');

        $response = $this->process($request);
        $this->detail = $response->json();

        return $response->isSuccessful();
    }

    /**
     * @param array $options
     *
     * @return bool
     */
    public function create(array $options)
    {
        $resourceURI = $this->getSubresourceURI($options['id']);

        $request = $this->client->post($resourceURI, array(), '', array('exceptions' => false));
        $request->setPostField('media_url', $options['media_url']);
        $request->setPostField('label', isset($options['label']) ? $options['label'] : '');
        $request->setPostField('audio_channel', isset($options['audio_channel']) ? $options['audio_channel'] : '');
        $request->setPostField('source', isset($options['source']) ? $options['source'] : '');

        $response = $this->process($request);
        $this->detail = $response->json();

        return $response->isSuccessful();
    }
}
