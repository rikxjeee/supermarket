<?php

namespace Supermarket\Controller;

use Supermarket\Model\Cart;
use Supermarket\Model\Product;
use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Renderer\Renderer;
use supermarket\Transformer\ProductToCartContentViewTransformer;

class CartPageController implements Controller
{
    private const SUPPORTED_REQUEST = 'mycart';

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
        Cart $cart,
        Renderer $renderer,
        ProductToCartContentViewTransformer $productToCartContentViewTransformer
    ) {
        $this->cart = $cart;
        $this->renderer = $renderer;
        $this->productToCartContentViewTransformer = $productToCartContentViewTransformer;
    }

    public function execute(Request $request): Response
    {
        /**
         * one product is hardcoded until feature to add them manually is implemented
         */
        $this->cart->addToCart(new Product(1, 'cola', 1, 'drink'));

        $cartContent = $this->cart->getCart();
        if(empty($cartContent)) {
            $content = $this->renderer->renderEmptyCart('/cart/empty_cart.html');
            return new Response($content);
        }
        $cartItemsView = $this->productToCartContentViewTransformer->transform($this->cart);
        $content = $this->renderer->renderCart($cartItemsView, 'cart/cartitem.html', 'cart/cartitem_container.html');
        return new Response($content);
    }

    public function supports(Request $request): bool
    {
       return $request->getQueryParam('page') === self::SUPPORTED_REQUEST;
    }
}
