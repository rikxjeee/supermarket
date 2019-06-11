<?php

namespace Supermarket\Controller;

use Exception;
use PDOException;
use Supermarket\Exception\ProductNotFoundException;
use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Renderer\Renderer;
use Supermarket\Repository\ProductRepository;
use Supermarket\Transformer\ProductToProductDetailsViewTransformer;

class ProductDetailsPageController implements Controller
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var Renderer
     */
    private $renderer;
    /**
     * @var ProductToProductDetailsViewTransformer
     */
    private $productToProductDetailsViewTransformer;

    public function __construct(
        ProductRepository $productRepository,
        Renderer $renderer,
        ProductToProductDetailsViewTransformer $productToProductDetailsViewTransformer
    ) {
        $this->productRepository = $productRepository;
        $this->renderer = $renderer;
        $this->productToProductDetailsViewTransformer = $productToProductDetailsViewTransformer;
    }

    public function execute(Request $request): Response
    {
        try {
            $id = $request->get('id');
            if ($id === null) {
                throw new Exception('Invalid request.');
            }

            $productDetailsTemplate = 'product_details.html';
            $product = $this->productRepository->getProductById($id);
            $productDetails = $this->productToProductDetailsViewTransformer->transform($product);
            $content = $this->renderer->renderProductDetails($productDetails, $productDetailsTemplate);
            $response = new Response($content);
        } catch (ProductNotFoundException $e) {
            return new Response($e->getMessage(), Response::STATUS_NOT_FOUND);
        } catch (PDOException $e) {
            return new Response($e->getMessage(), Response::STATUS_SERVER_ERROR);
        } catch (Exception $e) {
            return new Response($e->getMessage(), Response::STATUS_NOT_FOUND);
        }
        return $response;
    }
}
