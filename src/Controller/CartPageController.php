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
        $this->sessionManager::start();
        $this->sessionManager->addField('user_id', 2);
        $cartId = $this->sessionManager->getField('user_id');

        $this->cart = $this->databaseBasedCartRepository->getCartById($cartId);
        $this->sessionManager->addField('cart_id', $this->cart->getCartId());

        /**
         * one product is hardcoded until feature to add them manually is implemented
         */
        //$this->cart->addProduct(new Product(1, 'Coca Cola', 0.8, 'Soft Drink'));

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
