<?php

namespace Supermarket\Controller;

use InvalidArgumentException;
use Supermarket\Exception\ProductNotFoundException;
use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Model\Session;
use Supermarket\Renderer\Renderer;
use Supermarket\Repository\ProductRepository;
use Supermarket\Transformer\ProductToProductDetailsViewTransformer;

class ProductDetailsPageController implements Controller
{
    private const SUPPORTED_REQUEST = 'details';

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

    public function execute(Request $request, Session $session): Response
    {
        try {
            $id = $request->getQueryParam('id');
            if ($id === null) {
                throw new InvalidArgumentException('Invalid request.');
            }

            $productDetailsTemplate = 'product_details.html';
            $product = $this->productRepository->getProductById($id);
            $productDetails = $this->productToProductDetailsViewTransformer->transform($product);
            $content = $this->renderer->renderProductDetails($productDetails, $productDetailsTemplate);
            $response = new Response($content);
        } catch (ProductNotFoundException | InvalidArgumentException $e) {
            return new Response($e->getMessage(), Response::STATUS_NOT_FOUND);
        }

        return $response;
    }

    public function supports(Request $request): bool
    {
        return $request->getQueryParam('page') === self::SUPPORTED_REQUEST;
    }
}
