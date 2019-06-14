<?php

namespace Supermarket\Application;

use PDO;
use Supermarket\Application;
use Supermarket\Controller\CartPageController;
use Supermarket\Controller\Controller;
use Supermarket\Controller\PageNotFoundController;
use Supermarket\Controller\ProductDetailsPageController;
use Supermarket\Controller\ProductListPageController;
use Supermarket\Model\Config\ApplicationConfig;
use Supermarket\Provider\UrlProvider;
use Supermarket\Renderer\HTMLrenderer;
use Supermarket\Renderer\Renderer;
use Supermarket\Repository\DatabaseBasedCartRepository;
use Supermarket\Repository\DatabaseBasedProductRepository;
use Supermarket\Repository\ProductRepository;
use Supermarket\Transformer\ProductsToProductListViewTransformer;
use Supermarket\Transformer\ProductToCartContentViewTransformer;
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
        return new Router(
            [
                $this->getProductListPageController(),
                $this->getProductDetailsController(),
                $this->getCartPageController(),
            ],
            $this->getPageNotFoundController()
        );
    }

    public function getProductListPageController(): Controller
    {
        return new ProductListPageController(
            $this->getProductRepository(),
            $this->getRenderer(),
            $this->getProductsToProductListViewTransformer()
        );
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

    private function getUrlProvider(): UrlProvider
    {
        return new UrlProvider();
    }

    public function getProductDetailsController(): Controller
    {
        return new ProductDetailsPageController(
            $this->getProductRepository(),
            $this->getRenderer(),
            $this->getProductToProductDetailsTransformer());
    }

    private function getProductToProductDetailsTransformer(): ProductToProductDetailsViewTransformer
    {
        return new ProductToProductDetailsViewTransformer($this->getUrlProvider());
    }

    private function getCartPageController(): Controller
    {
        return new CartPageController(
            $this->getRenderer(),
            $this->getProductToCartContentViewTransformer());
    }

    private function getProductToCartContentViewTransformer(): ProductToCartContentViewTransformer
    {
        return new ProductToCartContentViewTransformer($this->getUrlProvider());
    }

    public function getPageNotFoundController(): Controller
    {
        return new PageNotFoundController();
    }

    public function getDataBaseBasedCartRepository(): DatabaseBasedCartRepository
    {
        return new DatabaseBasedCartRepository($this->getMySqlConnection());
    }
}
