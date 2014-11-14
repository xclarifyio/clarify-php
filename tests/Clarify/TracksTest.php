<?php
include '../vendor/autoload.php';

use Guzzle\Http;

class TracksTest extends PHPUnit_Framework_TestCase
{
    protected $bundle = null;
    protected $media  = 'http://media.clarify.io/audio/samples/harvard-sentences-1.wav';

    public function setUp()
    {
        global $apikey;

        $this->bundle = new \Clarify\Bundle($apikey);

        parent::setUp();
    }

    /**
     * @expectedException \Clarify\Exceptions\InvalidEnumTypeException
     */
    public function testCreateWithChannelException()
    {
        $params = array();
        $params['media_url'] = '';
        $params['label'] = '';
        $params['source'] = '';
        $params['audio_channel'] = 'neither channel';
        $this->bundle->tracks->create($params);
    }

    public function testCreate()
    {
        $name = 'name - testCreate' . rand(0, 500);
        $this->bundle->create($name, $this->media);

        $this->assertEquals(201, $this->bundle->getStatusCode());
        $location = $this->bundle->location;

        $params = array('media_url' => 'http://google.com', 'id' => $location);
        $this->bundle->tracks->create($params);

        $this->assertTrue($this->bundle->delete($location));
        $this->assertEquals(204, $this->bundle->getStatusCode());
    }
}