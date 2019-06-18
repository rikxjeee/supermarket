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

    public function __construct(string $content, int $statusCode = self::STATUS_OK)
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
