<?php

namespace Supermarket\Renderer;

use Supermarket\Datastore\Product;

interface Renderer
{
    /**
     * @param Product[] $products
     * @param string $template
     * @return string
     */
    public function renderProductListTable(array $products, string $template): string;
}
