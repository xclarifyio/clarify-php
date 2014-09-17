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

        $params = array();
        $params['media_url'] = $options['media_url'];
        $params['label'] = isset($options['label']) ? $options['label'] : '';
        $params['audio_channel'] = isset($options['audio_channel']) ? $options['audio_channel'] : '';
        $params['source'] = isset($options['source']) ? $options['source'] : '';

        $result = $this->client->post($resourceURI, $params);
        $this->detail = $this->client->detail;

        return $result;
    }
}
