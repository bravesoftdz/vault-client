<?php

namespace Dykyi\Enumeration;

use Eloquent\Enumeration\AbstractMultiton;

/**
 * Class EnvEnumeration
 * @package Dykyi\Enumeration
 */
final class EnvEnumeration extends AbstractMultiton
{
    /** @var int */
    private $type;

    protected static function initializeMembers()
    {
        new static('DEV', 'dev/');
        new static('TEST', 'test/');
        new static('PROD', 'prod/');
    }

    /**
     * @param string $key
     * @param int $value
     *
     * @throws \Exception
     */
    protected function __construct($key, $value)
    {
        parent::__construct($key);

        $this->type = $value;
    }

    /**
     * @return int
     */
    public function type()
    {
        return $this->type;
    }

}