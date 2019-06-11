<?php

namespace Supermarket\Renderer;

use Supermarket\Model\View\ProductDetailsView;
use Supermarket\Model\View\ProductListView;

interface Renderer
{
    public function renderProductListTable(ProductListView $products, string $template, string $tableTemplate): string;

    public function renderProductDetails(ProductDetailsView $product, string $productDetailsTemplate): string;
}
