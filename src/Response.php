<?php

namespace Supermarket;

class Response
{
    private const STATUS_OK = 200;
    public const STATUS_NOT_FOUND = 404;

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

    public function sendResponse(Response $response)
    {
        http_response_code($response->getStatusCode());
        echo $response->getContent();
    }
}
