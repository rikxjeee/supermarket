<?php

namespace Supermarket\Model;

class Request
{
    /**
     * @var string[]
     */
    private $queryParams;

    public function __construct(array $queryParams)
    {
        $this->queryParams = $queryParams;
    }

    public function get(string $key): ?string
    {
        return $this->queryParams[$key] ?? null;
    }
}
