<?php

namespace Supermarket\Application;

use PDO;
use Supermarket\Application;
use Supermarket\Controller\Controller;
use Supermarket\Controller\PageNotFoundController;
use Supermarket\Controller\ProductDetailsPageController;
use Supermarket\Controller\ProductListPageController;
use Supermarket\Model\DatabaseCredentials;
use Supermarket\Renderer\HTMLrenderer;
use Supermarket\Renderer\Renderer;
use Supermarket\Repository\DatabaseBasedProductRepository;
use Supermarket\Repository\ProductRepository;

class ServiceContainer
{
    /**
     * @var array
     */
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function getApplication(): Application
    {
        return new Application($this);
    }

    public function getRouter(): Router
    {
        return new Router();
    }

    public function getProductListPageController(): Controller
    {
        return new ProductListPageController($this->getProductRepository(), $this->getRenderer());
    }

    public function getProductDetailsController(): Controller
    {
        return new ProductDetailsPageController($this->getProductRepository(), $this->getRenderer());
    }

    public function getPageNotFoundController(): Controller
    {
        return new PageNotFoundController();
    }

    private function getProductRepository(): ProductRepository
    {
        return new DatabaseBasedProductRepository($this->getMySqlConnection());
    }

    private function getRenderer(): Renderer
    {
        return new HTMLrenderer($this->getTemplateBasePath());
    }

    private function getMySqlConnection(): PDO
    {
        return new PDO(...$this->getDataBaseCredentials()->toPDOConfig());
    }

    private function getTemplateBasePath(): string
    {
        return $this->config['templates']['basepath'] ?? '';
    }

    private function getDataBaseCredentials(): DatabaseCredentials
    {
        return DatabaseCredentials::createFromArray($this->config['db']['connection'] ?? []);
    }
}
