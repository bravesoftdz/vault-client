<?php

use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
 *
 * @coversDefaultClass Client
 */
class ClientTest extends TestCase
{

    public static function setUpBeforeClass()
    {
        //...
    }

    /**
     * @coversNothing
     */
    public function testEnv()
    {
        $this->assertNotEmpty(getenv('VAULT_HOST'));
    }

    public function testStart()
    {
        $this->assertTrue(true);
    }
}
