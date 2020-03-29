<?php

namespace App\Entity;

class Cart
{
    /** @var int */
    private $id;

    /** @var CartItem[] */
    private $items;

    public function __construct(int $id, array $items = [])
    {
        $this->id = $id;
        $this->items = $items;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return CartItem[]
     */
    public function getItems(): array
    {
        return $this->items;
    }

    public function addProduct(Product $product, int $quantity = 1): void
    {
        $productId = $product->getId();
        if (isset($this->items[$productId])) {
            $this->items[$productId]->increaseQuantity();
        } else {
            $this->items[$productId] = new CartItem($product, $quantity);
        }
    }
}
