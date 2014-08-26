<?php

namespace Clarify;

/**
 * Class Bundle
 * @package Clarify
 *
 * @property metadata   This is the metadata subresource of the bundle.
 * @property tracks     This is the tracks subresource of the bundle.
 */
class Bundle extends Client
{
    public function create($name, $media_url = '', $metadata = '', $notify_url = '', $audio_channel = '')
    {
        $params = array();
        $params['name'] = $name;
        $params['media_url'] = $media_url;
        $params['metadata'] = $metadata;
        $params['notify_url'] = $notify_url;
        $params['audio_channel'] = $audio_channel;

        return $this->post($params);
    }

    /**
     * @param array $options
     * @return bool
     * @throws InvalidEnumTypeException
     * @throws InvalidJSONException
     */
    public function post(array $options)
    {
        $metadata = isset($options['metadata']) ? $options['metadata'] : '';
        $ob = json_decode($metadata);
        if ($metadata != '' && $ob === null) {
            throw new InvalidJSONException();
        }

        $audio_channel = isset($options['audio_channel']) ? $options['audio_channel'] : '';
        if (!in_array($audio_channel, array('left', 'right', 'split', ''))) {
            throw new InvalidEnumTypeException();
        }

        return parent::post($options);
    }

    public function update($id, $name = '', $notify_url = '', $version  = 1)
    {
        $params = array();
        $params['id'] = $id;
        $params['name'] = $name;
        $params['notify_url'] = $notify_url;
        $params['version'] = $version;

        return $this->put($params);
    }
}