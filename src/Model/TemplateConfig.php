<?php

namespace Supermarket\Model;

class TemplateConfig
{
    /**
     * @var string
     */
    private $basePath;

    public static function createFromArray(array $data): TemplateConfig
    {
        return new self($data['basepath']);
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    private function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }
}
