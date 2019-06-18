<?php

namespace Supermarket\Model;

class Response
{
    public const STATUS_OK = 200;
    public const STATUS_NOT_FOUND = 404;
    public const STATUS_SERVER_ERROR = 500;
    public const STATUS_REDIRECT = 302;

    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $statusCode;

    /** @var string */
    private $header;

    public function __construct(string $content, int $statusCode = self::STATUS_OK, string $header = null)
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->header = $header;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getHeader(): string
    {
        return $this->header;
    }

    public function hasHeader(): bool
    {
        return $this->header !== null;
    }
}
