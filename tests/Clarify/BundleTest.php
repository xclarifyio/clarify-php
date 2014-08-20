<?php
include '../vendor/autoload.php';

use Guzzle\Http;

class BundleTest extends PHPUnit_Framework_TestCase
{
    protected $apiKey = '123';

    /**
     * @expectedException Guzzle\Http\Exception\CurlException
     * @expectedException Clarify\Exceptions\InvalidResourceException
     */
    public function testCreate()
    {
        $name = 'name' . rand(0, 500);
        $media = 'https://s3-us-west-2.amazonaws.com/op3nvoice/harvard-sentences-1.wav';

        $client = $this->createMockClient();
        $client->create($name, $media);
        $this->assertEquals(32, strlen($client->id));
        $this->assertEquals($name, strlen($client->name));
    }


    protected function createMockClient()
    {
        $http = Mockery::mock(new Http\Client());
        return new \Clarify\Bundle($this->apiKey, $http);
    }
}