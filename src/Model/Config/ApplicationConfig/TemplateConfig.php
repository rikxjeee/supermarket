<?php

namespace Supermarket\Model\Config\ApplicationConfig;

class TemplateConfig
{
    /**
     * @var string
     */
    private $basePath;

    public function getBasePath(): string
    {
        return $this->basePath;
    }

    public static function createFromArray(array $data): TemplateConfig
    {
        return new self($data['basepath']);
    }

    private function __construct(string $basePath)
    {
        $this->basePath = $basePath;
    }
}
