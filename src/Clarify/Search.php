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
     */
    public function search($query, $limit = 10, $params = array())
    {
        $params['query'] = urlencode($query);
        $params['limit'] = (int) $limit;

        return $this->get('search', $params);
    }

    public function hasMorePages()
    {
        return isset($this->detail['_links']['next']);
    }

    public function getNextPage()
    {
        return $this->getPage('next');
    }

    public function getPreviousPage()
    {
        return $this->getPage('prev');
    }

    protected function getPage($direction = 'next')
    {
        if (isset($this->detail['_links'][$direction])) {
            $next_uri = $this->detail['_links'][$direction]['href'];
            $this->detail = $this->client->get($next_uri);
        } else {
            $this->detail = json_encode(array());
        }

        return $this->detail;
    }
}
