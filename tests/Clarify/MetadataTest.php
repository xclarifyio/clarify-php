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
        $this->bundle = new \Clarify\Bundle($apikey, $this->client);
        $this->metadata = new \Clarify\Metadata($this->client);

        parent::setUp();
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

    public function testUpdate()
    {
        $name = 'name - testMetadataUpdate';
        $result = $this->bundle->create($name, $this->media);
        $this->assertEquals(201, $this->bundle->getStatusCode());
        $location = $result->getHeader('Location');

        $params = array('data' => '{"name" : "value"}', 'id' => $location);
        $result = $this->bundle->metadata->update($params);
        $this->assertTrue($result);

        $this->assertTrue($this->bundle->delete($location));
        $this->assertEquals(204, $this->bundle->getStatusCode());
    }
}