<?php

namespace Clarify;

use Clarify\Exceptions\InvalidJSONException;

/**
 * Class Metadata
 * @package Clarify
 */
class Metadata extends Subresource
{
    protected $subresource = 'clarify:metadata';

    /**
     * @param array $options
     * @return bool
     * @throws Exceptions\InvalidJSONException
     */
    public function update(array $options)
    {
        $data = isset($options['data']) ? $options['data'] : '';
        $ob = json_decode($data);
        if($data != '' && $ob === null) {
            throw new InvalidJSONException();
        }

        $resourceURI = $this->getSubresourceURI($options['id']);

        $params = array();
        $params['id'] = $resourceURI;
        $params['data'] = $data;
        $params['version'] = isset($options['version']) ? (int) $options['version'] : 1;

        $result = $this->client->put($params);
        $this->detail = $this->client->detail;

        return $result;
    }
}
