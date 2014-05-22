<?php

namespace OP3Nvoice;

class Search extends Client
{
    public $detail = null;

    /**
     * @param $query
     * @param int $limit
     * @param string $embed
     * @param string $iterator
     * @return array|bool|float|int|string
     */
    public function search($query, $limit = 10, $embed = '', $iterator = '')
    {
        $request = $this->client->get('/v1/search', array(), array('exceptions' => false));

        $request->getQuery()->set('query', $query);
        $request->getQuery()->set('limit', $limit);
        $request->getQuery()->set('embed', $embed);

        $response = $this->process($request);

        $this->detail = $response->json();

        return $response->json();
    }
}