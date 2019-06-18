<?php

namespace Supermarket\Model;

class Response
{
    public const STATUS_OK = 200;
    public const STATUS_NOT_FOUND = 404;
    public const STATUS_SERVER_ERROR = 500;
    public const STATUS_PERMANENT_REDIRECT = 301;
    public const STATUS_TEMPORARY_REDIRECT = 302;


    /**
     * @var string
     */
    private $content;

    /**
     * @var int
     */
    private $statusCode;

    /** @var array */
    private $headers;

    public function __construct(string $content, int $statusCode = self::STATUS_OK, array $headers = [])
    {
        $this->content = $content;
        $this->statusCode = $statusCode;
        $this->headers = $headers;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function hasHeader(): bool
    {
        return empty($this->header);
    }

    public function getHeaders(): string
    {
       $headers = '';
       foreach ($this->headers as $key => $header) {
           $headers .= sprintf('%s: %s', $key, $header);
       }

       return $headers;
    }
}
