<?php

namespace Dykyi;

use Dykyi\Service\Cache\CacheInterface;
use Dykyi\Exception\ClientException;
use Dykyi\Service\Cache\NullCache;
use GuzzleHttp\ClientInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Stash\Driver\Ephemeral;
use Stash\Interfaces\DriverInterface;
use Stash\Interfaces\PoolInterface;
use Stash\Pool;

/**
 * Class BaseClient
 * @package Dykyi
 */
abstract class BasicClient implements LoggerAwareInterface
{
    /**
     * @var LoggerInterface
     */
    protected $logger;

    /**
     * @var PoolInterface
     */
    protected $cache;

    /**
     * @var ResponseDataExtractor
     */
    protected $extractor;

    /**
     * @var ClientInterface
     */
    protected $client = null;

    /**
     * BaseClient constructor.
     *
     * @param LoggerInterface|null $logger
     * @param ClientInterface $client
     * @param ResponseDataExtractor $extractor
     *
     * @throws ClientException
     */
    public function __construct(ClientInterface $client, ResponseDataExtractor $extractor, LoggerInterface $logger = null)
    {
        $this->client = $client;
        $this->extractor = $extractor;
        $this->logger = $logger ?: new NullLogger();
        $this->cache = new Pool(new Ephemeral());
    }

    /**
     * @param DriverInterface $driver
     * @param array $options
     */
    public function setCache(DriverInterface $driver, $options)
    {
        $driver->setOptions($options);
        $this->cache = new Pool($driver);
    }


    /**
     * Sets a logger.
     *
     * @param LoggerInterface $logger
     *
     * @return $this
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        return $this;
    }
}
