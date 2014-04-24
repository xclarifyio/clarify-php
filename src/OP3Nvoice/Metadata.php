<?php

namespace OP3Nvoice;

use OP3Nvoice\Exceptions\InvalidJSONException;

class Metadata extends Subresource
{
    protected $subresource = 'o3v:metadata';

    public function load($id)
    {
        $resourceURI = $this->getSubresourceURI($id);

        $request = $this->client->get($resourceURI, array(), array('exceptions' => false));
        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->json();
    }

    public function update($id, $data, $version = '')
    {
        $resourceURI = $this->getSubresourceURI($id);

        $ob = json_decode($data);
        if($data != '' && $ob === null) {
            throw new InvalidJSONException();
        }

        $request = $this->client->put($resourceURI, array(), '', array('exceptions' => false));
        $request->setPostField('data', $data);
        $request->setPostField('version', $version);

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->isSuccessful();
    }
}