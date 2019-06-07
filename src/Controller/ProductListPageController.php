<?php

namespace Supermarket\Controller;

use Supermarket\Datastore\Credentials;
use Supermarket\Datastore\ProductRepository;
use Supermarket\Renderer\Renderer;
use Supermarket\Request;
use Supermarket\Response;

class ProductListPageController implements ProductPageController
{

    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var Credentials
     */
    private $credentials;
    /**
     * @var Renderer
     */
    private $renderer;
    /**
     * @var Request
     */
    private $request;

    public function __construct(ProductRepository $productRepository, Credentials $credentials, Renderer $renderer, Request $request)
    {
        $this->productRepository = $productRepository;
        $this->credentials = $credentials;
        $this->renderer = $renderer;
        $this->request = $request;
    }

    public function viewAction(): Response
    {
        $productListTemplate = file_get_contents('./src/Template/ProductList.html');
        $products = $this->productRepository->getAllProducts();
        $productList = $this->renderer->renderProductList($products);
        if(!in_array($this->request->getGET()['page'], ['products', 'details', ''])){
            $response = new Response('404 - Page not found.', 404);
            return $response;
        }
        $response = new Response(str_replace('%PRODUCTS%', $productList, $productListTemplate), 200);
        return $response;
    }
}
