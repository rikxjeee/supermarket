<?php

namespace Supermarket;

class Response
{
    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $statusCode;

    public function __construct(string $content, int $statusCode)
    {

        $this->content = $content;
        $this->statusCode = $statusCode;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
