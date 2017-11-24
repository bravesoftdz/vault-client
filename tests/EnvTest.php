<?php

use PHPUnit\Framework\TestCase;

/**
 * Class EnvTest
 *
 */
class EnvTest extends TestCase
{

    /**
     * @beforeClass
     */
    public static function initEnv()
    {
        $dotenv = new \Dotenv\Dotenv(__DIR__);
        $dotenv->load();
    }

    /**
     * @coversNothing
     */
    public function testEnv()
    {
        $this->assertEmpty(getenv('VAULT_HOST_TEST'));
    }

    /**
     * @coversNothing
     */
    public function testNotEnv()
    {
        $this->assertNotEmpty(getenv('VAULT_HOST'));
    }

}
