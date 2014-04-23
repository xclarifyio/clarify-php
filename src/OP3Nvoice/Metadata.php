<?php

namespace OP3Nvoice;

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
}