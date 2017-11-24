<?php

namespace Dykyi\Service\Cache;

class NullCache implements CacheInterface
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
        return null;
    }

    /**
     * @param string $key
     * @param array $value
     *
     * @return bool
     */
    public function write($key, $value)
    {
        return true;
    }

    /**
     * @param string $key
     * @param array $value
     * @return bool
     */
    public function update($key, $value)
    {
        return true;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        return true;
    }
}