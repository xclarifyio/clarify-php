<?php

namespace Clarify;

/**
 * Class Tracks
 * @package Clarify
 */
class Insights extends Subresource
{
    protected $subresource = 'clarify:insights';

    public function get($insight)
    {
        $this->detail = $this->client->get($insight);

        return $this->detail;
    }

    public function __get($name)
    {
        $data = $this->detail['track_data'][0];

        if (array_key_exists($name, $data)) {
            return $data[$name];
        }

        throw new \Clarify\Exceptions\InvalidResourceException('Not supported');
    }
}