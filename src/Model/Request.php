<?php

namespace Supermarket\Model;

class Request
{
    /**
     * @var string[]
     */
    private $queryParams;

    public function __construct(array $get)
    {
        $this->queryParams = $get;
    }

    public function get(string $key): ?string
    {
        return $this->queryParams[$key] ?? null;
    }
}
