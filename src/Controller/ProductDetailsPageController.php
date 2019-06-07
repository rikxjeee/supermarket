<?php

namespace Supermarket\Controller;

use Supermarket\Datastore\Credentials;
use Supermarket\Datastore\ProductRepository;
use Supermarket\Renderer\Renderer;
use Supermarket\Request;
use Supermarket\Response;

class ProductDetailsPageController implements ProductPageController
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
        $product = $this->productRepository->getProductById($this->request->getGET()['id']);
        $productList = $this->renderer->renderProductList([$product]);
        if(!in_array($this->request->getGET()['page'], ['products', 'details', ''])){
            $response = new Response('404 - Page not found.', 404);
            return $response;
        }
        $content = str_replace('%PRODUCTS%', $productList, $productListTemplate);
        $response = new Response('<table>'.$content.'</table><br><a href="index.php">Back</a>', 200);
        return $response;
    }
}
