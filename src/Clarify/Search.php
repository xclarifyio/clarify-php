<?php

namespace Clarify;

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

        $request->getQuery()->set('query', $query);
        $request->getQuery()->set('limit', $limit);
        foreach($params as $key => $value) {
            $request->getQuery()->set($key, $value);
        }

        $response = $this->process($request);

        $this->detail = $response->json();

        return $response->json();
    }
}
