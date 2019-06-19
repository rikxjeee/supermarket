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

    public function getId(): int
    {
        return $this->cartId;
    }

    /**
     * @return CartItem[]
     */
    public function getItems(): array
    {
        return $this->cartItems;
    }

    public function addProduct(Product $product, int $quantity = 1): void
    {
        if (isset($this->cartItems[$product->getId()])) {
            $this->cartItems[$product->getId()]->increaseQuantity($quantity);
        } else {
            $this->cartItems[$product->getId()] = new CartItem($product, $quantity);
        }
    }
}
