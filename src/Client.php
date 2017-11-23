<?php

namespace Dykyi;

use Dykyi\Enumeration\EnvEnumeration;
use Dykyi\Enumeration\VaultHttpStatusEnumeration;
use Dykyi\Exception\ClientException;
use Dykyi\Exception\TransferException;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;

/**
 * Class Client
 * @package Dykyi
 */
class Client extends BaseClient
{
    /**
     * @var EnvEnumeration
     */
    private $env = null;

    private $options = [];

    /**
     * Client constructor.
     *
     * @param ClientInterface $client
     * @param ResponseDataExtractor $extractor
     * @param null $logger
     */
    public function __construct(ClientInterface $client, ResponseDataExtractor $extractor, $logger = null)
    {
        parent::__construct($client, $extractor, $logger);

        // init env
        $this->initEnv();

        // set default env
        $this->setEnvironment(EnvEnumeration::DEV());

        // set default options
        $this->options = [
            'base_uri' => getenv('VAULT_HOST'),
            'http_errors' => false,
            'headers' => [
                'X-Vault-Token' => getenv('VAULT_ROOT_TOKEN_ID'),
                'Content-Type' => 'application/json',
            ]
        ];
    }

    /**
     * @param string $key
     * @return string
     */
    private function buildUri($key = '')
    {
        return  '/v1/secret/' . $this->getEnv() . $key;
    }

    /**
     * @return EnvEnumeration
     */
    public function getEnv()
    {
        return $this->env;
    }

    /**
     * @param EnvEnumeration $env
     */
    public function setEnvironment(EnvEnumeration $env)
    {
        $this->env = $env->type();
    }

    /**
     * Validate initialization
     *
     * @throws \RuntimeException
     *
     * @return bool
     */
    public function init()
    {
        $response = $this->send(new Request('GET', '/v1/sys/init'), $this->options);

        $data = $this->extractor->extract($response);

        if (!is_object($data)) {
            $this->logger->error('Error in validate the initialization');

            return false;
        }

        return property_exists($data, 'initialized');
    }

    /**
     * @param RequestInterface $request
     * @param array $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function send(RequestInterface $request, $options = [])
    {
        $this->logger->info(sprintf('%s "%s"', $request->getMethod(), $request->getUri()));

        try {
            $response = $this->client->send($request, $options);
        } catch (TransferException $e) {
            $message = sprintf('Something went wrong when calling vault (%s).', $e->getMessage());
            $this->logger->error($message);
        }

        if (VaultHttpStatusEnumeration::INVALID_REQUEST()->id() <= $response->getStatusCode()) {
            $message = sprintf('Something went wrong when calling vault (%s - %s).', $response->getStatusCode(), $response->getReasonPhrase());
            $this->logger->error($message);

            throw new ClientException($message, $response->getStatusCode(), $request);
        }

        return $response;
    }

    /**
     * Read key from Vault
     *
     * @param string $key
     *
     * @throws \RuntimeException
     *
     * @return \stdClass|null
     */
    public function read($key)
    {
        $response = $this->send(new Request('GET', $this->buildUri($key)), $this->options);
        $extract = $this->extractor->extract($response);

        return $extract->data;
    }

    /**
     * @param $key
     * @param array $data
     * @return bool
     */
    public function write($key, array $data)
    {
        $options = array_merge(['json' => $data], $this->options);
        $response = $this->send(new Request('POST', $this->buildUri($key)), $options);

        return $response->getStatusCode() === VaultHttpStatusEnumeration::SUCCESS_NO_DATA()->id();
    }


}