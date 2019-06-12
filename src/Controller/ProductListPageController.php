<?php

namespace Supermarket\Controller;

use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Renderer\Renderer;
use Supermarket\Repository\ProductRepository;
use Supermarket\Transformer\ProductsToProductListViewTransformer;

class ProductListPageController implements Controller
{
    private const SUPPORTED_REQUESTS = ['products', '', null];

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var ProductsToProductListViewTransformer
     */
    private $productsToProductListViewTransformer;

    public function __construct(
        ProductRepository $productRepository,
        Renderer $renderer,
        ProductsToProductListViewTransformer $productsToProductListViewTransformer
    ) {
        $this->productRepository = $productRepository;
        $this->renderer = $renderer;
        $this->productsToProductListViewTransformer = $productsToProductListViewTransformer;
    }

    public function execute(Request $request): Response
    {
        $productListTemplate = '/product_list/item.html';
        $tableTemplate = 'product_list.html';
        $products = $this->productRepository->getAllProducts();
        $productListView = $this->productsToProductListViewTransformer->transform($products);
        $productList = $this->renderer->renderProductListTable($productListView, $productListTemplate, $tableTemplate);
        $response = new Response($productList);

        return $response;
    }

    public function supports(?string $request)
    {
        foreach (self::SUPPORTED_REQUESTS as $supportedRequest) {
            if ($request === $supportedRequest) {
                return true;
            }
        }

        return false;
    }
}
