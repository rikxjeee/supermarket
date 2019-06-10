<?php

namespace Supermarket\Controller;

use Supermarket\Datastore\ProductRepository;
use Supermarket\Renderer\Renderer;
use Supermarket\Request;
use Supermarket\Response;

class ProductListPageController implements PageController
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var Renderer
     */
    private $renderer;

    public function __construct(ProductRepository $productRepository, Renderer $renderer)
    {
        $this->productRepository = $productRepository;
        $this->renderer = $renderer;
    }

    public function execute(Request $request): Response
    {
        $productListTemplate = './src/Template/Product.html';
        $tableTemplate = './src/Template/ProductListTable.html';
        $products = $this->productRepository->getAllProducts();
        $productList = $this->renderer->renderProductListTable($products, $productListTemplate, $tableTemplate);
        $response = new Response($productList);

        return $response;
    }
}
