<?php
include '../vendor/autoload.php';

use Guzzle\Http;

class MetadataTest extends PHPUnit_Framework_TestCase
{
    protected $bundle = null;
    protected $media  = 'http://media.clarify.io/audio/samples/harvard-sentences-1.wav';

    public function setUp()
    {
        global $apikey;

        $this->client = new \Clarify\Client($apikey);
        $this->metadata = new \Clarify\Metadata($this->client);

        parent::setUp();
    }

    public function testUpdate()
    {
        $this->markTestIncomplete();
    }

    /**
     * @expectedException \Clarify\Exceptions\InvalidJSONException
     */
    public function testUpdateWithJSONException()
    {
        $params = array('data' => 'not a json string');
        $this->metadata->update($params);
    }

    /**
     * @expectedException \Clarify\Exceptions\InvalidIntegerArgumentException
     */
    public function testUpdateWithIntegerException()
    {
        $params = array('version' => 'not an integer');
        $this->metadata->update($params);
    }
}