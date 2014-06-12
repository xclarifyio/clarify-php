<?php

namespace OP3Nvoice\Tests\Services;

use OP3Nvoice\Bus\Bus;

class FunctionalTest extends \PHPUnit_Framework_TestCase
{
    /** @var \OP3Nvoice\Bus\Bus */
    protected $bus;

    public function setUp()
    {
        $apiKey = require __DIR__.'/../../examples/creds.php';

        $this->bus = new Bus($apiKey);
    }

    /**
     * @test
     */
    public function it_gets_bundles()
    {
        /** @var \OP3Nvoice\Bus\ClientStub $client */
        $client = $this->bus->getClient();
        /** @var \GuzzleHttp\Command\Model $result */
        $model = $client->getBundles();

        $result = $model->toArray();
        $this->assertArrayHasKey('total', $result);
        $this->assertArrayHasKey('limit', $result);
        $this->assertArrayHasKey('_class', $result);
        $this->assertArrayHasKey('_links', $result);
    }
}
