<?php

namespace Supermarket\Transformer;

use Supermarket\Model\Cart;
use Supermarket\Model\View\CartContentView;
use Supermarket\Model\View\CartItemView\CartItemView;
use Supermarket\Provider\UrlProvider;

class ProductToCartContentViewTransformer
{
    /**
     * @var UrlProvider
     */
    private $urlProvider;

    public function __construct(UrlProvider $urlProvider)
    {
        $this->urlProvider = $urlProvider;
    }

    public function transform(Cart $cart): CartContentView
    {
        if (empty($cart->getItems())) {
            return new CartContentView([]);
        }

        $cartItems = $cart->getItems();
        $cartContentView = [];
        foreach ($cartItems as $key => $cartItem) {
            $cartContentView[] = new CartItemView(
                $cartItem->getProduct()->getName(),
                $cartItem->getProduct()->getPrice(),
                $cartItem->getQuantity(),
                $this->urlProvider->getProductUrl($cartItem->getProduct()->getId())
            );
        }

        return new CartContentView($cartContentView);
    }
}
