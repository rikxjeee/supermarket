<?php

namespace Supermarket\Controller;

use Supermarket\Application\SessionManager;
use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Repository\CartRepository;
use Supermarket\Repository\ProductRepository;

class AddToCartController implements Controller
{
    private const SUPPORTED_REQUEST = 'addtocart';

    /** @var SessionManager */
    private $sessionManager;

    /** @var CartRepository */
    private $cartRepository;

    /** @var ProductRepository */
    private $productRepository;

    public function __construct(
        SessionManager $sessionManager,
        CartRepository $cartRepository,
        ProductRepository $productRepository
    ) {
        $this->sessionManager = $sessionManager;
        $this->cartRepository = $cartRepository;
        $this->productRepository = $productRepository;
    }

    public function execute(Request $request): Response
    {
        $cartId = $this->sessionManager->getValue('cart_id');
        $productId = $request->getPostParam('product_id');
        $quantity = $request->getPostParam('quantity');
        $cart = $this->cartRepository->getById($cartId);
        $cart->addProduct($this->productRepository->getProductById($productId), $quantity);
        $this->cartRepository->save($cart);
        return new Response('', Response::STATUS_TEMPORARY_REDIRECT, ['Location'=> 'index.php?page=cart']);
    }

    public function supports(Request $request): bool
    {
        return self::SUPPORTED_REQUEST == $request->getQueryParam('page');
    }
}
