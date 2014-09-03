<?php

namespace Clarify;

/**
 * Class Tracks
 * @package Clarify
 */
class Tracks extends Subresource
{
    protected $subresource = 'clarify:tracks';

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
