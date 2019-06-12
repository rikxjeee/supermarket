<?php

namespace Supermarket\Application;

use PDO;
use Supermarket\Application;
use Supermarket\Controller\Controller;
use Supermarket\Controller\PageNotFoundController;
use Supermarket\Controller\ProductDetailsPageController;
use Supermarket\Controller\ProductListPageController;
use Supermarket\Model\Config\ApplicationConfig;
use Supermarket\Provider\UrlProvider;
use Supermarket\Renderer\HTMLrenderer;
use Supermarket\Renderer\Renderer;
use Supermarket\Repository\DatabaseBasedProductRepository;
use Supermarket\Repository\ProductRepository;
use Supermarket\Transformer\ProductsToProductListViewTransformer;
use Supermarket\Transformer\ProductToProductDetailsViewTransformer;

class DefaultServiceContainer implements ServiceContainer
{
    /**
     * @var ApplicationConfig
     */
    private $config;

    public function __construct(ApplicationConfig $config)
    {
        $this->config = $config;
    }

    public function getApplication(): Application
    {
        return new Application($this);
    }

    public function getRouter(): Router
    {
        $router = new Router();
        $router->register('products', $this->getProductListPageController());
        $router->register('details', $this->getProductDetailsController());
        $router->register('default', $this->getPageNotFoundController());
        $router->register('', $this->getProductListPageController());

        return $router;
    }

    public function getProductListPageController(): Controller
    {
        return new ProductListPageController(
            $this->getProductRepository(),
            $this->getRenderer(),
            $this->getProductsToProductListViewTransformer()
        );
    }

    public function getPageNotFoundController(): Controller
    {
        return new PageNotFoundController();
    }

    public function getProductDetailsController(): Controller
    {
        return new ProductDetailsPageController($this->getProductRepository(), $this->getRenderer(), $this->getProductToProductDetailsTransformer());
    }

    private function getProductRepository(): ProductRepository
    {
        return new DatabaseBasedProductRepository($this->getMySqlConnection());
    }

    private function getMySqlConnection(): PDO
    {
        return new PDO(...$this->config->getDataBaseCredentials()->toPDOConfig());
    }

    private function getRenderer(): Renderer
    {
        return new HTMLrenderer($this->config->getTemplateConfig());
    }

    private function getProductsToProductListViewTransformer(): ProductsToProductListViewTransformer
    {
        return new ProductsToProductListViewTransformer($this->getUrlProvider());
    }

    private function getProductToProductDetailsTransformer(): ProductToProductDetailsViewTransformer
    {
        return new ProductToProductDetailsViewTransformer();
    }

    private function getUrlProvider()
    {
        return new UrlProvider();
    }
}
