<?php
include '../vendor/autoload.php';

use Guzzle\Http;

class ClientTest extends PHPUnit_Framework_TestCase
{
    protected $client = null;

    public function setUp()
    {
        global $apikey;

        $this->client = new \Clarify\Client($apikey);

        parent::setUp();
    }

    /**
     * @expectedException \Clarify\Exceptions\InvalidIntegerArgumentException
     */
    public function testPutWithException()
    {
        $params = array('version' => 'not an integer');
        $this->client->put('empty url', $params);
    }
}