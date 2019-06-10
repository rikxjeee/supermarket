<?php

namespace Supermarket;

class Request
{
    /**
     * @var array
     */
    private $get;

    public function __construct(array $get)
    {
        $this->get = $get;
    }

    public function get(string $key)
    {
        return $this->get[$key];
    }
}
