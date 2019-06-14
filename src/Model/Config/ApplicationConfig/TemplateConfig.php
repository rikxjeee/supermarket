<?php

namespace Supermarket\Model\Config\ApplicationConfig;

class TemplateConfig
{
    /**
     * @var string
     */
    private $basePath;

    private function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }

    public static function createFromArray(array $data): TemplateConfig
    {
        return new self($data['basepath']);
    }

    public function getBasePath(): string
    {
        return $this->basePath;
    }
}
