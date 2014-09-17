<?php

namespace Clarify;

/**
 * Class Subresource
 * @package Clarify
 */
abstract class Subresource
{
    protected $subresource;
    protected $client = null;
    public $detail = null;

    public function __construct(\Clarify\Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param $id
     * @return mixed
     */
    protected function getSubresourceURI($id)
    {
        $request = $this->client->get($id, array(), array('exceptions' => false));;

        return $request['_links'][$this->subresource]['href'];
    }

    /**
     * @param $id
     * @return array|bool|float|int|string
     */
    public function load($id)
    {
        $resourceURI = $this->getSubresourceURI($id);

        return $this->client->get($resourceURI);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $resourceURI = $this->getSubresourceURI($id);

        return parent::delete($resourceURI);
    }
}