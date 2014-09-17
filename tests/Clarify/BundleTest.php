<?php
include '../vendor/autoload.php';

use Guzzle\Http;

class BundleTest extends PHPUnit_Framework_TestCase
{
    protected $bundle = null;
    protected $media  = 'http://media.clarify.io/audio/samples/harvard-sentences-1.wav';

    public function setUp()
    {
        global $apikey;

        $this->bundle = new \Clarify\Bundle($apikey);

        parent::setUp();
    }

    public function testCreate()
    {
        $name = 'name - testCreate' . rand(0, 500);
        $result = $this->bundle->create($name, $this->media);

        $this->assertEquals(201, $this->bundle->getStatusCode());
        $location = $result->getHeader('Location');
        $this->assertEquals(44, strlen($location));
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
        $this->markTestIncomplete();
    }
}