<?php

namespace Supermarket\Model\Config;

use Supermarket\Model\Config\ApplicationConfig\DatabaseConfig;
use Supermarket\Model\Config\ApplicationConfig\TemplateConfig;

class ApplicationConfig
{
    /**
     * @var DatabaseConfig
     */
    private $databaseCredentials;

    /**
     * @var TemplateConfig
     */
    private $templateConfig;

    public static function createFromArray(array $data): ApplicationConfig
    {
        return new self(
            DatabaseConfig::createFromArray($data['db']['connection']),
            TemplateConfig::createFromArray($data['templates'])
        );
    }

    public function getTemplateConfig(): TemplateConfig
    {
        return $this->templateConfig;
    }

    public function getDataBaseCredentials(): DatabaseConfig
    {
        return $this->databaseCredentials;
    }

    private function __construct(DatabaseConfig $databaseCredentials, TemplateConfig $templateConfig)
    {
        $this->databaseCredentials = $databaseCredentials;
        $this->templateConfig = $templateConfig;
    }
}
