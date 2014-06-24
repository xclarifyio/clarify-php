<?php

namespace OP3Nvoice;

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
}