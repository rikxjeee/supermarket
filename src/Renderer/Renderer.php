<?php

namespace Supermarket\Renderer;

use Supermarket\Datastore\Product;

interface Renderer
{
    /**
     * @param Product[] $products
     * @return string
     */
    public function renderProductList(array $products): string;
}
