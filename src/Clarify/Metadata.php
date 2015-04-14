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
     * @return mixed
     * @throws Exceptions\InvalidJSONException
     * @throws InvalidIntegerArgumentException
     */
    public function update(array $options)
    {
        $data = isset($options['data']) ? $options['data'] : '';
        $ob = json_decode($data);
        if($data != '' && $ob === null) {
            throw new InvalidJSONException();
        }

        $params = array();
        $params['data'] = $data;
        if (isset($options['version'])) {
            $params['version'] = (int) $options['version'];
        }
        $resourceURI = $this->getSubresourceURI($options['id']);

        $result = $this->client->put($resourceURI, $params);
        $this->detail = $this->client->detail;

        return $result;
    }
}
