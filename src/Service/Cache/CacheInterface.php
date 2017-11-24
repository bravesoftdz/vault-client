<?php

namespace Dykyi\Service\Cache;

interface CacheInterface
{
    /**
     * @param array $params
     * @return void
     */
    public function connect(array $params);

    /**
     * @param $key
     *
     * @return mixed
     */
    public function read($key);

    /**
     * @param string $key
     * @param array $value
     *
     * @return bool
     */
    public function write($key, $value);

    /**
     * @param string $key
     * @param array $value
     * @return bool
     */
    public function update($key, $value);

    /**
     * @param string $key
     * @return bool
     */
    public function delete($key);
}