<?php

namespace Supermarket\Model\View;

use Supermarket\Model\View\ProductListView\Item;

class ProductListView
{
    /**
     * @var Item[]
     */
    private $items;

    /**
     * ProductListView constructor.
     * @param Item[] $items
     */
    public function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
