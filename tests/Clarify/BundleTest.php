<?php
include '../vendor/autoload.php';

use Guzzle\Http;

class BundleTest extends PHPUnit_Framework_TestCase
{
    protected $bundle = null;

    public function setUp()
    {
        global $apikey;

        $this->bundle = new \Clarify\Bundle($apikey);

        parent::setUp();
    }

    public function testCreate()
    {
        $name = 'name - testCreate' . rand(0, 500);
        $media = 'http://media.clarify.io/audio/samples/harvard-sentences-1.wav';
        $result = $this->bundle->create($name, $media);

        $this->assertEquals(201, $result->getStatusCode());
        $location = $result->getHeader('Location');
        $this->assertEquals(44, strlen($location));
    }

    public function testUpdate()
    {
        $name = 'name - testUpdate';
        $media = 'http://media.clarify.io/audio/samples/harvard-sentences-1.wav';
        $result = $this->bundle->create($name, $media);

        $this->assertEquals(201, $result->getStatusCode());
        $location = $result->getHeader('Location');

        $this->assertTrue($this->bundle->update($location, 'updated'));
    }
}