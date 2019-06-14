<?php

namespace Supermarket\Model;

class Cart
{
    /**
     * @var CartItem[]
     */
    private $cartItems = [];

    /** @var int */
    private $cartId;

    public function __construct(int $cartId)
    {
        $this->cartId = $cartId;
    }

    public function getCartId(): int
    {
        return $this->cartId;
    }

    public function getItems()
    {
        return $this->cartItems;
    }

    public function addProduct(Product $product)
    {
        if (isset($this->cartItems[$product->getId()])) {
            $this->cartItems[$product->getId()]->increaseQuantity();
        } else {
            $this->cartItems[$product->getId()] = new CartItem($product);
        }
    }
}
