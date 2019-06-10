<?php

namespace Supermarket\Controller;

use Exception;
use Supermarket\Datastore\ProductRepository;
use Supermarket\Renderer\Renderer;
use Supermarket\Request;
use Supermarket\Response;

class ProductDetailsPageController implements PageController
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
        try {
            $id = $request->get('id');
            if ($id === null) {
                throw new Exception('Invalid request.');
            }

            $productDetailsTemplate = './src/Template/ProductDetails.html';
            $product = $this->productRepository->getProductById($id);
            $content = $this->renderer->renderProductDetails($product, $productDetailsTemplate);
            $response = new Response($content);
        } catch (Exception $e) {
            return new Response($e->getMessage(), Response::STATUS_NOT_FOUND);
        }

        return $response;
    }
}
