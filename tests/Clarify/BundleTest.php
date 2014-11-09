<?php
include '../vendor/autoload.php';

use Guzzle\Http;

class BundleTest extends PHPUnit_Framework_TestCase
{
    protected $bundle = null;
    protected $client = null;
    protected $media  = 'http://media.clarify.io/audio/samples/harvard-sentences-1.wav';

    public function setUp()
    {
        global $apikey;

        $this->client = new \Clarify\Client($apikey);
        $this->bundle = new \Clarify\Bundle($apikey, $this->client);

        parent::setUp();
    }

    public function testCreate()
    {
        $name = 'name - testCreate' . rand(0, 500);
        $result = $this->bundle->create($name, $this->media);

        $this->assertEquals(201, $this->bundle->getStatusCode());
        $location = $result->getHeader('Location');
        $this->assertEquals(44, strlen($location));

        $this->assertTrue($this->bundle->delete($location));
        $this->assertEquals(204, $this->bundle->getStatusCode());
    }

    /**
     * @expectedException \Clarify\Exceptions\InvalidJSONException
     */
    public function testCreateWithJSONException()
    {
        $name = 'name - testCreate';
        $this->bundle->create($name, $this->media, 'not a json string');
    }

    /**
     * @expectedException \Clarify\Exceptions\InvalidEnumTypeException
     */
    public function testCreateWithChannelException()
    {
        $name = 'name - testCreate';
        $this->bundle->create($name, $this->media, '', '', 'neither channel!');
    }

    public function testUpdate()
    {
        $name = 'name - testUpdate';
        $result = $this->bundle->create($name, $this->media);

        $this->assertEquals(201, $this->bundle->getStatusCode());
        $location = $result->getHeader('Location');

        $this->assertTrue($this->bundle->update($location, 'updated'));
        $this->assertEquals(202, $this->bundle->getStatusCode());
    }

    /**
     * @expectedException \Clarify\Exceptions\InvalidIntegerArgumentException
     */
    public function testUpdateWithException()
    {
        $this->bundle->update('id', 'name', 'http://google.com', 'not a version string');
    }

    public function testDelete()
    {
        $name = 'name - testUpdate';
        $result = $this->bundle->create($name, $this->media);

        $this->assertEquals(201, $this->bundle->getStatusCode());
        $location = $result->getHeader('Location');

        $this->assertTrue($this->bundle->delete($location));
        $this->assertEquals(204, $this->bundle->getStatusCode());

        $this->bundle->load($location);
        $this->assertEquals(404, $this->bundle->getStatusCode());
    }

    public function testIndex()
    {
        $data = $this->bundle->index();
        $items = $data['_links']['items'];
        $this->assertEquals(10, $data['limit']);
        $this->assertLessThanOrEqual(10, count($items));

        $data = $this->bundle->index(2);
        $items = $data['_links']['items'];
        $this->assertEquals(2, $data['limit']);
        $this->assertLessThanOrEqual(2, count($items));
    }

    public function test__get()
    {
        $object = $this->bundle->tracks;
        $this->assertInstanceOf('\Clarify\Tracks', $object);

        $object = $this->bundle->metadata;
        $this->assertInstanceOf('\Clarify\Metadata', $object);
    }

    /**
     * @expectedException \Clarify\Exceptions\InvalidResourceException
     */
    public function test__getWithException()
    {
        $object = $this->bundle->monkey;
    }
}