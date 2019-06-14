<?php

namespace Supermarket\Controller;

use Supermarket\Application\SessionManager;
use Supermarket\Model\Cart;
use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Renderer\Renderer;
use Supermarket\Repository\DatabaseBasedCartRepository;
use supermarket\Transformer\ProductToCartContentViewTransformer;

class CartPageController implements Controller
{
    private const SUPPORTED_REQUEST = 'cart';

    /**
     * @var Cart
     */
    private $cart;

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

        /**
         * carts are statically stored in db until feature to add them manually is implemented
         */
        $this->cart = $this->databaseBasedCartRepository->getCartById($cartId);
        $this->sessionManager->setValue('cart_id', $this->cart->getCartId());

        //$this->cart->addProduct(new Product(1, 'Coca Cola', 0.8, 'Soft Drink'));

        $cartItemsView = $this->productToCartContentViewTransformer->transform($this->cart);
        $content = $this->renderer->renderCart(
            $cartItemsView,
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
