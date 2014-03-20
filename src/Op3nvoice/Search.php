<?php

namespace Op3nvoice;

class Search extends Client
{
    public $detail = null;

    public function search($query, $limit = 10, $embed = '', $iterator = '')
    {
        $request = $this->client->get('/search', array(), array('exceptions' => false));

        $request->getQuery()->set('query', $query);
        $request->getQuery()->set('limit', $limit);
        $request->getQuery()->set('embed', $embed);

        $request->addHeader('Authorization', $this->apiKey);
        $response = $request->send();

//todo: catch null results
        $this->detail = $response->json();

        return $response->json();
    }
}