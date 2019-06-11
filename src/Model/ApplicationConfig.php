<?php

namespace Supermarket\Model;

class ApplicationConfig
{
    /**
     * @var DatabaseCredentials
     */
    private $databaseCredentials;

    /**
     * @var TemplateConfig
     */
    private $templateConfig;

    public static function createFromArray(array $data): ApplicationConfig
    {
        return new self(
            DatabaseCredentials::createFromArray($data['db']['connection']),
            TemplateConfig::createFromArray($data['templates'])
        );
    }

    public function getTemplateConfig(): TemplateConfig
    {
        return $this->templateConfig;
    }

    public function getDataBaseCredentials(): DatabaseCredentials
    {
        return $this->databaseCredentials;
    }

    private function __construct(DatabaseCredentials $databaseCredentials, TemplateConfig $templateConfig)
    {
        $this->databaseCredentials = $databaseCredentials;
        $this->templateConfig = $templateConfig;
    }
}
