<?php

use PHPUnit\Framework\TestCase;
use Dykyi\VaultClient;

/**
 * Class VaultClientTest
 *
 * @coversDefaultClass VaultClient
 *
 */
class VaultClientTest extends TestCase
{
    private $vaultMockClient;

    /**
     * @param $object
     * @param $property
     * @param $value
     */
    public function setProtectedProperty($object, $property, $value)
    {
        $reflection = new ReflectionClass($object);
        $reflection_property = $reflection->getProperty($property);
        $reflection_property->setAccessible(true);
        $reflection_property->setValue($object, $value);
    }

    public function initProvider()
    {
        $extractorResult = new stdClass();
        $extractorResult->initialized = '1';
        return [
            [$extractorResult, true],
            [null, false],
        ];
    }

    /**
     * @covers ::init
     *
     * @param $param
     * @param $expect
     *
     * @dataProvider initProvider
     */
    public function testInit($param, $expect)
    {
        $extractor = $this->getMockBuilder(\Dykyi\ResponseDataExtractor::class)
            ->disableOriginalConstructor()
            ->setMethods(['extract'])
            ->getMock();

        $extractor->expects($this->once())
            ->method('extract')
            ->willReturn($param)
            ->with(new \GuzzleHttp\Psr7\Response());

        $this->vaultMockClient = $this->getMockBuilder(VaultClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['send'])
            ->getMock();

        $this->setProtectedProperty($this->vaultMockClient, 'extractor', $extractor);
        $this->setProtectedProperty($this->vaultMockClient, 'logger', new \Psr\Log\NullLogger());

        $this->vaultMockClient->expects($this->any())
            ->method('send')
            ->willReturn(new \GuzzleHttp\Psr7\Response())
            ->with(new \GuzzleHttp\Psr7\Request('GET', '/v1/sys/init'), []);

        $this->assertEquals($expect, $this->vaultMockClient->init());
    }

    /**
     *
     * @covers ::write
     */
    public function testWrite()
    {
        // Create a mock and queue two responses.
        $mock = new \GuzzleHttp\Handler\MockHandler([
            new \GuzzleHttp\Psr7\Response(204, ['X-Foo' => 'Bar']),
            new \GuzzleHttp\Exception\RequestException("Error Communicating with Server",
                new \GuzzleHttp\Psr7\Request('GET', 'test'))
        ]);

        $handler = \GuzzleHttp\HandlerStack::create($mock);
        $client  = new \GuzzleHttp\Client(['handler' => $handler]);

        $this->vaultMockClient = $this->getMockBuilder(VaultClient::class)
            ->disableOriginalConstructor()
            ->setMethods(['send'])
            ->getMock();

        $this->setProtectedProperty($this->vaultMockClient, 'cache', new \Stash\Pool(new \Stash\Driver\Ephemeral()));

        $this->vaultMockClient->expects($this->any())
            ->method('send')
            ->willReturn($client->request('GET', '/'))
            ->with(new \GuzzleHttp\Psr7\Request('POST', '/v1/secret/test', []));

        $this->assertTrue($this->vaultMockClient->write('test',['test'=>'value']));
    }

}
