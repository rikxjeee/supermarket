<?php

namespace Supermarket;

use InvalidArgumentException;

class Request
{
    /**
     * @var array
     */
    private $queryParams;

    public function __construct(array $get)
    {
        $this->queryParams = $get;
    }

    /**
     * @param string $key
     * @return string
     * @throws InvalidArgumentException
     */
    public function get(string $key): string
    {
        if(!array_key_exists($key, $this->queryParams)) {
            throw new InvalidArgumentException('Invalid request.');
        }
        return $this->queryParams[$key];
    }
}
