<?php

namespace Supermarket\Controller;

use Supermarket\Datastore\ProductRepository;
use Supermarket\Renderer\Renderer;
use Supermarket\Request;
use Supermarket\Response;

class ProductListPageController
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

    public function viewAction(Request $request): Response
    {
        $productListTemplate = './src/Template/Product.html';
        $products = $this->productRepository->getAllProducts();
        $productList = $this->renderer->renderProductListTable($products, $productListTemplate);
        $response = new Response($productList);

        return $response;
    }
}
