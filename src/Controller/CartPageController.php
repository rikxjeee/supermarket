<?php

namespace Supermarket\Controller;

use Supermarket\Application\SessionManager;
use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Renderer\Renderer;
use Supermarket\Repository\CartRepository;
use supermarket\Transformer\ProductToCartContentViewTransformer;

class CartPageController implements Controller
{
    private const SUPPORTED_REQUEST = 'cart';

    /**
     * @var Renderer
     */
    private $renderer;

    /**
     * @var ProductToCartContentViewTransformer
     */
    private $productToCartContentViewTransformer;

    /** @var SessionManager */
    private $sessionManager;

    /** @var CartRepository */
    private $cartRepository;

    public function __construct(
        Renderer $renderer,
        ProductToCartContentViewTransformer $productToCartContentViewTransformer,
        SessionManager $sessionManager,
        CartRepository $cartRepository
    ) {
        $this->renderer = $renderer;
        $this->productToCartContentViewTransformer = $productToCartContentViewTransformer;
        $this->sessionManager = $sessionManager;
        $this->cartRepository = $cartRepository;
    }

    public function execute(Request $request): Response
    {
        $cartId = $this->sessionManager->getValue('cart_id');
        $cart = $this->cartRepository->getById($cartId);
        $cartContentView = $this->productToCartContentViewTransformer->transform($cart);
        $content = $this->renderer->renderCart(
            $cartContentView,
            'cart/item/item.html',
            'cart/cart.html',
            'cart/empty_cart.html'
        );

        return new Response($content);
    }

    public function supports(Request $request): bool
    {
        return $request->getQueryParam('page') === self::SUPPORTED_REQUEST;
    }
}
