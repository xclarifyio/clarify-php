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