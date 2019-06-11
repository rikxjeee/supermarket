<?php

namespace Supermarket\Controller;

use Supermarket\Renderer\Renderer;
use Supermarket\Repository\ProductRepository;
use Supermarket\Model\Request;
use Supermarket\Model\Response;

class ProductListPageController implements Controller
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
        $productListTemplate = 'Product.html';
        $tableTemplate = 'ProductListTable.html';
        $products = $this->productRepository->getAllProducts();
        $productList = $this->renderer->renderProductListTable($products, $productListTemplate, $tableTemplate);
        $response = new Response($productList);

        return $response;
    }
}
