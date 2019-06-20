<?php

namespace Supermarket\Application;

use PDO;
use Supermarket\Application;
use Supermarket\Controller\AddToCartController;
use Supermarket\Controller\CartPageController;
use Supermarket\Controller\Controller;
use Supermarket\Controller\PageNotFoundController;
use Supermarket\Controller\ProductDetailsPageController;
use Supermarket\Controller\ProductListPageController;
use Supermarket\Model\Config\ApplicationConfig;
use Supermarket\Provider\UrlProvider;
use Supermarket\Renderer\HTMLrenderer;
use Supermarket\Renderer\Renderer;
use Supermarket\Repository\CartRepository;
use Supermarket\Repository\DatabaseBasedCartRepository;
use Supermarket\Repository\DatabaseBasedProductRepository;
use Supermarket\Repository\ProductRepository;
use Supermarket\Transformer\ProductsToProductListViewTransformer;
use Supermarket\Transformer\ProductToCartContentViewTransformer;
use Supermarket\Transformer\ProductToProductDetailsViewTransformer;
use Supermarket\Transformer\TotalToPriceViewTransformer;

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
        return new Application($this->getRouter(), $this->getSessionManager());
    }

    private function getRouter(): Router
    {
        return new Router(
            [
                $this->getProductListPageController(),
                $this->getProductDetailsController(),
                $this->getCartPageController(),
                $this->getAddToCartController()
            ],
            $this->getPageNotFoundController()
        );
    }

    private function getProductListPageController(): Controller
    {
        return new ProductListPageController(
            $this->getProductRepository(),
            $this->getRenderer(),
            $this->getProductsToProductListViewTransformer()
        );
    }

    private function getProductDetailsController(): Controller
    {
        return new ProductDetailsPageController(
            $this->getProductRepository(),
            $this->getRenderer(),
            $this->getProductToProductDetailsTransformer());
    }

    private function getCartPageController(): Controller
    {
        return new CartPageController(
            $this->getRenderer(),
            $this->getProductToCartContentViewTransformer(),
            $this->getTotalToPriceViewTransformer(),
            $this->getSessionManager(),
            $this->getCartRepository(),
            $this->getGrandTotalCalculator()
        );
    }

    private function getPageNotFoundController(): Controller
    {
        return new PageNotFoundController();
    }

    private function getSessionManager(): SessionManager
    {
        return new SessionManager();
    }

    private function getCartRepository(): CartRepository
    {
        return new DatabaseBasedCartRepository($this->getMySqlConnection(), $this->getProductRepository());
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
        return new HTMLrenderer($this->config->getTemplateConfig(), $this->getUrlProvider(), $this->getSessionManager());
    }

    private function getProductsToProductListViewTransformer(): ProductsToProductListViewTransformer
    {
        return new ProductsToProductListViewTransformer($this->getUrlProvider());
    }

    private function getUrlProvider(): UrlProvider
    {
        return new UrlProvider();
    }

    private function getProductToProductDetailsTransformer(): ProductToProductDetailsViewTransformer
    {
        return new ProductToProductDetailsViewTransformer($this->getUrlProvider());
    }

    private function getProductToCartContentViewTransformer(): ProductToCartContentViewTransformer
    {
        return new ProductToCartContentViewTransformer($this->getUrlProvider());
    }

    private function getAddToCartController(): Controller
    {
        return new AddToCartController(
            $this->getSessionManager(),
            $this->getCartRepository(),
            $this->getProductRepository(),
            $this->getUrlProvider()
        );
    }

    private function getFullPriceCalculator(): Calculator
    {
        return new FullPriceCalculator();
    }

    private function getDiscountCalculator(): Calculator
    {
        return new DiscountCalculator();
    }

    private function getGrandTotalCalculator(): GrandTotalCalculator
    {
        return new GrandTotalCalculator($this->getFullPriceCalculator(), $this->getDiscountCalculator());
    }

    private function getTotalToPriceViewTransformer()
    {
        return new TotalToPriceViewTransformer();
    }
}
