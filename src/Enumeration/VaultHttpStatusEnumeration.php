<?php

namespace Dykyi\Enumeration;

use Eloquent\Enumeration\AbstractMultiton;

/**
 * Class VaultHttpStatusEnumeration
 * @package Dykyi\Enumeration
 */
final class VaultHttpStatusEnumeration extends AbstractMultiton
{
    /** @var int */
    private $id;

    protected static function initializeMembers()
    {
        new static('SUCCESS', 200);
        new static('SUCCESS_NO_DATA', 204);
        new static('INVALID_REQUEST', 400);
        new static('FORBIDDEN', 403);
        new static('INVALID_PATH', 404);
        new static('WARNING', 429);
        new static('INTERNAL_SERVER_ERROR', 500);
        new static('VAULT_ID_DOWN', 503);
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

        $this->id = $value;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

}