<?php

namespace OP3Nvoice;

use OP3Nvoice\Exceptions\InvalidJSONException;

class Metadata extends Client
{
    public function load($id)
    {
        $request = $this->client->get($id, array(), array('exceptions' => false));
        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $bundle = $response->json();
        $metadataURI = $bundle['_links']['o3v:metadata']['href'];

        $request = $this->client->get($metadataURI, array(), array('exceptions' => false));
        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->json();
    }

    public function update($id, $data, $version = '')
    {
        $request = $this->client->get($id, array(), array('exceptions' => false));
        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $bundle = $response->json();
        $metadataURI = $bundle['_links']['o3v:metadata']['href'];

        $ob = json_decode($data);
        if($data != '' && $ob === null) {
            throw new InvalidJSONException();
        }

        $request = $this->client->put($metadataURI, array(), '', array('exceptions' => false));
        $request->setPostField('data', $data);
        $request->setPostField('version', $version);

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->isSuccessful();
    }

    public function delete($id)
    {
        $request = $this->client->get($id, array(), array('exceptions' => false));
        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $bundle = $response->json();
        $metadataURI = $bundle['_links']['o3v:metadata']['href'];

        $request = $this->client->delete($metadataURI, array(), '', array('exceptions' => false));

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->isSuccessful();
    }
}