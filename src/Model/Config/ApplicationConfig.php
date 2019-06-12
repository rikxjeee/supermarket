<?php

namespace Supermarket\Model\Config;

use InvalidArgumentException;
use Supermarket\Model\Config\ApplicationConfig\DatabaseConfig;
use Supermarket\Model\Config\ApplicationConfig\TemplateConfig;

class ApplicationConfig
{
    private const DBCONFIG = 'db';
    private const TEMPLATES = 'templates';

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
        if (!isset($data[self::DBCONFIG])) {
            throw new InvalidArgumentException('Database configuration missing.');
        }

        if (!isset($data[self::TEMPLATES])) {
            throw new InvalidArgumentException('Template configuration missing.');
        }

        return new self(
            DatabaseConfig::createFromArray((array)$data[self::DBCONFIG]),
            TemplateConfig::createFromArray((array)$data[self::TEMPLATES])
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
