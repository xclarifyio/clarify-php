<?php

namespace Clarify;

use Clarify\Exceptions\InvalidEnumTypeException;

/**
 * Class Tracks
 * @package Clarify
 */
class Tracks extends Subresource
{
    protected $subresource = 'clarify:tracks';

    /**
     * @param array $options
     * @return \Guzzle\Http\Message\Response|null
     * @throws InvalidEnumTypeException
     */
    public function create(array $options)
    {
        $params = array();
        $params['media_url'] = $options['media_url'];
        $params['label'] = isset($options['label']) ? $options['label'] : '';
        $params['source'] = isset($options['source']) ? $options['source'] : '';
        $params['audio_channel'] = isset($options['audio_channel']) ? $options['audio_channel'] : '';
        if (!in_array($params['audio_channel'], array('left', 'right', 'split', ''))) {
            throw new InvalidEnumTypeException();
        }

        $resourceURI = $this->getSubresourceURI($options['id']);
        $result = $this->client->post($resourceURI, $params);
        $this->detail = $this->client->detail;

        return $result;
    }
}
