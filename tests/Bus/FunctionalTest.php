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

    public function testX()
    {
        $client = $this->bus->getClient();

        try {
            $result = $client->getBundles();
        } catch (\Exception $e) {
            ladybug_dump_die($e->getMessage());
        }


        $this->assertTrue(true);
    }
}
