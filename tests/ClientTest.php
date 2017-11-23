<?php

use PHPUnit\Framework\TestCase;

/**
 * Class ClientTest
 *
 * @coversDefaultClass Client
 */
class ClientTest extends TestCase
{
    /**
     * Init env
     */
    private static function initEnv()
    {
        if (!file_exists(__DIR__.'/../.env')) {
            throw new \Exception(sprintf('File %s not found!', '.env'));
        }
        $dotenv = new \Dotenv\Dotenv(__DIR__.'/../');
        $dotenv->load();
    }

    public static function setUpBeforeClass()
    {
        self::initEnv();
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
