<?php

namespace App\Entity;

class CartItem
{
    /** @var int */
    private $quantity;

    /** @var Product*/
    private $product;

    public function __construct(Product $product, int $quantity = 1)
    {
        $this->product = $product;
        $this->quantity = $quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function increaseQuantity(): void
    {
        $this->quantity += 1;
    }
}
