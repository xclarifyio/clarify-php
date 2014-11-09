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
}