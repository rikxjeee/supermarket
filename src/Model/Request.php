<?php

namespace Supermarket\Model;

class Request
{
    /**
     * @var string[]
     */
    private $queryParams;

    /** @var array */
    private $postParams;

    public function __construct(array $queryParams, array $postParams)
    {
        $this->queryParams = $queryParams;
        $this->postParams = $postParams;
    }

    public function getQueryParam(string $key): ?string
    {
        return $this->queryParams[$key] ?? null;
    }

    public function getPostParam(string $string): ?string
    {
        return $this->postParams[$string] ?? null;
    }

    public function isPost(): bool
    {
        return $_SERVER['REQUEST_METHOD'] === 'POST';
    }
}
