<?php

namespace OP3Nvoice;

abstract class Subresource extends Client
{
    protected function getSubresourceURI($id)
    {
        $request = $this->client->get($id, array(), array('exceptions' => false));
        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $bundle = $response->json();

        return $bundle['_links'][$this->subresource]['href'];
    }

    public function load($id)
    {
        $resourceURI = $this->getSubresourceURI($id);

        $request = $this->client->get($resourceURI, array(), array('exceptions' => false));
        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->json();
    }

    public function delete($id)
    {
        $resourceURI = $this->getSubresourceURI($id);

        $request = $this->client->delete($resourceURI, array(), '', array('exceptions' => false));

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();
        $this->detail = $response->json();

        return $response->isSuccessful();
    }
}