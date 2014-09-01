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


    /**
     * @expectedException Guzzle\Http\Exception\CurlException
     * @expectedException Clarify\Exceptions\InvalidResourceException
     */
    public function testCreate()
    {
        $name = 'name' . rand(0, 500);
        $media = 'http://media.clarify.io/audio/samples/harvard-sentences-1.wav';
        $this->bundle->create($name, $media);

        $this->assertEquals(32,     strlen($this->bundle->id));
        $this->assertEquals($name,  $this->bundle->name);
    }
}