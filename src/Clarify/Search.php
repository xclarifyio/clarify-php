<?php

namespace Clarify;

/**
 * Class Search
 * @package Clarify
 *
 * @deprecated since 1.3 Use \Clarify\Bundle->search() instead
 */
class Search extends Client
{
    public $detail = null;

    /**
     * @param $query
     * @param int $limit
     * @param array $params
     * @return array|bool|float|int|string
     *
     * @deprecated
     */
    public function search($query, $limit = 10, $params = array())
    {
        $request = $this->client->get('/v1/search', array(), array('exceptions' => false));

        $request->getQuery()->set('query', urlencode($query));
        $request->getQuery()->set('limit', (int) $limit);
        foreach($params as $key => $value) {
            $request->getQuery()->set($key, $value);
        }

        $this->process($request);

        $this->detail = $this->response->json();

        return $this->detail;
    }

    /** @deprecated */
    public function hasMorePages()
    {
        return isset($this->detail['_links']['next']);
    }

    /** @deprecated */
    public function getNextPage()
    {
        if (isset($this->detail['_links']['next'])) {
            $next = $this->detail['_links']['next']['href'];
            $this->detail = $this->client->get($next);
        } else {
            $this->detail = json_encode(array());
        }

        return $this->detail;
    }

    /** @deprecated */
    public function getPreviousPage()
    {
        if (isset($this->detail['_links']['prev'])) {
            $previous = $this->detail['_links']['prev']['href'];
            $this->detail = $this->client->get($previous);
        } else {
            $this->detail = json_encode(array());
        }

        return $this->detail;
    }
}
