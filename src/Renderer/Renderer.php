<?php

namespace Supermarket\Renderer;

use Supermarket\Datastore\Product;

interface Renderer
{
    /**
     * @param Product[] $products
     * @param string $template
     * @param string $tableTemplate
     * @return string
     */
    public function renderProductListTable(array $products, string $template, string $tableTemplate): string;

    public function renderProductDetails(Product $product, string $productDetailsTemplate): string;

    public function renderWebPage(string $content, string $template): string;
}
