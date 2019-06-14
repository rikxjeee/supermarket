<?php

namespace Supermarket\Controller;

use Supermarket\Model\Cart;
use Supermarket\Model\Product;
use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Model\Session;
use Supermarket\Renderer\Renderer;
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

    public function __construct(
        Renderer $renderer,
        ProductToCartContentViewTransformer $productToCartContentViewTransformer
    ) {
        $this->renderer = $renderer;
        $this->productToCartContentViewTransformer = $productToCartContentViewTransformer;
    }

    public function execute(Request $request, Session $session): Response
    {
        $this->cart = $session->getField('cart');

        /**
         * one product is hardcoded until feature to add them manually is implemented
         */
        $this->cart->addProduct(new Product(1, 'Coca Cola', 0.8, 'Soft Drink'));

        $cartContent = $this->cart->getItems();
        if (empty($cartContent)) {
            $content = $this->renderer->renderEmptyCart('/cart/empty_cart.html');

            return new Response($content);
        }
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
