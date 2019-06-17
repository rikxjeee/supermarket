<?php

namespace Supermarket\Controller;

use Supermarket\Application\SessionManager;
use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Renderer\Renderer;
use Supermarket\Repository\DatabaseBasedCartRepository;
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

    /** @var DatabaseBasedCartRepository */
    private $databaseBasedCartRepository;

    public function __construct(
        Renderer $renderer,
        ProductToCartContentViewTransformer $productToCartContentViewTransformer,
        SessionManager $sessionManager,
        DatabaseBasedCartRepository $databaseBasedCartRepository
    ) {
        $this->renderer = $renderer;
        $this->productToCartContentViewTransformer = $productToCartContentViewTransformer;
        $this->sessionManager = $sessionManager;
        $this->databaseBasedCartRepository = $databaseBasedCartRepository;
    }

    public function execute(Request $request): Response
    {
        $this->sessionManager->start();
        $this->sessionManager->setValue('cart_id', 1);
        $cartId = $this->sessionManager->getValue('cart_id');
        $cart = $this->databaseBasedCartRepository->getById($cartId);
        $cartContentView = $this->productToCartContentViewTransformer->transform($cart);
        $content = $this->renderer->renderCart(
            $cartContentView,
            'cart/cartitem.html',
            'cart/cartitem_container.html',
            'cart/empty_cart.html'
        );

        return new Response($content);
    }

    public function supports(Request $request): bool
    {
        return $request->getQueryParam('page') === self::SUPPORTED_REQUEST;
    }
}
