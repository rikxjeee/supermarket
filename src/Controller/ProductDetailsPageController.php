<?php

namespace Supermarket\Controller;

use Exception;
use PDOException;
use Supermarket\Exception\ProductNotFoundException;
use Supermarket\Renderer\Renderer;
use Supermarket\Repository\ProductRepository;
use Supermarket\Model\Request;
use Supermarket\Model\Response;

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

            $productDetailsTemplate = 'ProductDetails.html';
            $product = $this->productRepository->getProductById($id);
            $content = $this->renderer->renderProductDetails($product, $productDetailsTemplate);
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
