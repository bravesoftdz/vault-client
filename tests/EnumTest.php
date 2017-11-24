<?php

use PHPUnit\Framework\TestCase;
use Dykyi\Enumeration\EnvEnumeration;

/**
 * Class EnumTest
 *
 * @coversDefaultClass EnvEnumeration
 */
class EnumTest extends TestCase
{

    /**
     * @covers ::setEnvironment
     */
    public function testEnumeration()
    {
        $client = new \Dykyi\VaultClient(new \GuzzleHttp\Client(), new \Dykyi\ResponseDataExtractor());
        $this->assertEquals($client->getEnv(), EnvEnumeration::DEV()->type());

        $client->setEnvironment(EnvEnumeration::TEST());
        $this->assertEquals($client->getEnv(), EnvEnumeration::TEST()->type());
    }

}
