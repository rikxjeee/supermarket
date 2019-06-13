<?php

namespace Supermarket\Model\View;

use Supermarket\Model\View\CartItemView\CartItemView;

class CartContentView
{
    /**
     * @var CartItemView[]
     */
    private $items;

    /**
     * CartContentView constructor.
     * @param CartItemView[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return CartItemView[]
     */
    public function getCartContent(): array
    {
        return $this->items;
    }
}
