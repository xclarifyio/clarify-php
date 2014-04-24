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
}