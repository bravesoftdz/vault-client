<?php

namespace Dykyi\Service\Cache;

class RedisDriver implements CacheInterface
{
    /**
     * @param array $params
     * @return void
     */
    public function connect(array $params)
    {
        // TODO: Implement connect() method.
    }

    /**
     * @param $key
     *
     * @return mixed
     */
    public function read($key)
    {
        // TODO: Implement read() method.
    }

    /**
     * @param string $key
     * @param array $value
     *
     * @return bool
     */
    public function write($key, $value)
    {
        // TODO: Implement write() method.
    }

    /**
     * @param string $key
     * @param array $value
     * @return bool
     */
    public function update($key, $value)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        // TODO: Implement delete() method.
    }
}