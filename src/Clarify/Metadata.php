<?php

namespace Clarify;

use Clarify\Exceptions\InvalidJSONException;

class Metadata extends Subresource
{
    protected $subresource = 'o3v:metadata';

    /**
     * @param array $options
     * @return bool
     * @throws Exceptions\InvalidJSONException
     */
    public function update(array $options)
    {
        $data = isset($options['data']) ? $options['data'] : '';
        $version = isset($options['version']) ? $options['version'] : '';
        $resourceURI = $this->getSubresourceURI($options['id']);

        $ob = json_decode($data);
        if($data != '' && $ob === null) {
            throw new InvalidJSONException();
        }

        $request = $this->client->put($resourceURI, array(), '', array('exceptions' => false));
        $request->setPostField('data', $data);
        $request->setPostField('version', $version);
        $response = $this->process($request);

        $this->detail = $response->json();

        return $response->isSuccessful();
    }
}
