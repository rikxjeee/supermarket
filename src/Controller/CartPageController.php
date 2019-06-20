<?php

namespace Supermarket\Controller;

use Supermarket\Application\Calculator;
use Supermarket\Application\GrandTotalCalculator;
use Supermarket\Application\SessionManager;
use Supermarket\Model\Request;
use Supermarket\Model\Response;
use Supermarket\Renderer\Renderer;
use Supermarket\Repository\CartRepository;
use Supermarket\Transformer\TotalToPriceViewTransformer;
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

    /** @var Calculator */
    private $calculator;

    /** @var TotalToPriceViewTransformer */
    private $totalToPriceViewTransformer;

    public function __construct(
        Renderer $renderer,
        ProductToCartContentViewTransformer $productToCartContentViewTransformer,
        TotalToPriceViewTransformer $totalToPriceViewTransformer,
        SessionManager $sessionManager,
        CartRepository $cartRepository,
        GrandTotalCalculator $calculator
    ) {
        $this->renderer = $renderer;
        $this->productToCartContentViewTransformer = $productToCartContentViewTransformer;
        $this->sessionManager = $sessionManager;
        $this->cartRepository = $cartRepository;
        $this->calculator = $calculator;
        $this->totalToPriceViewTransformer = $totalToPriceViewTransformer;
    }

    public function execute(Request $request): Response
    {
        $cartId = $this->sessionManager->getValue('cart_id');
        $cart = $this->cartRepository->getById($cartId);
        if (empty($cart->getItems())) {
            $content = $this->renderer->renderEmptyCart('cart/empty_cart.html');
            return  new Response($content);
        }

        $totals[] = $this->calculator->getFullPrice($cart);
        $totals[] = $this->calculator->getDiscount($cart);
        $totals[] = $this->calculator->getTotal($cart);
        $pricesView = $this->totalToPriceViewTransformer->transform($totals);
        $cartContentView = $this->productToCartContentViewTransformer->transform($cart);
        $content = $this->renderer->renderCart(
            $cartContentView,
            $pricesView,
            'cart/item/item.html',
            'cart/cart.html',
        );

        return new Response($content);
    }

    public function supports(Request $request): bool
    {
        return $request->getQueryParam('page') === self::SUPPORTED_REQUEST;
    }
}
