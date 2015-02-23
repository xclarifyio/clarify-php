<?php

namespace Clarify;

/**
 * Class Search
 * @package Clarify
 */
class Search extends Client
{
    public $detail = null;

    /**
     * @param $query
     * @param int $limit
     * @param array $params
     * @return array|bool|float|int|string
     */
    public function search($query, $limit = 10, $params = array())
    {
        $request = $this->client->get('/v1/search', array(), array('exceptions' => false));

        $request->getQuery()->set('query', urlencode($query));
        $request->getQuery()->set('limit', (int) $limit);
        foreach($params as $key => $value) {
            $request->getQuery()->set($key, $value);
        }

        $response = $this->process($request);

        $this->detail = $response->json();

        return $response->json();
    }

    public function hasMorePages()
    {
        return isset($this->detail['_links']['next']);
    }

    public function getNextPage()
    {
        $next = $this->detail['_links']['next']['href'];
        $this->detail = $this->client->get($next);

        return $this->detail;
    }

    public function getPreviousPage()
    {
        $previous = $this->detail['_links']['prev']['href'];
        $this->detail = $this->client->get($previous);

        return $this->detail;
    }
}
