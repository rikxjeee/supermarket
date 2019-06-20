<?php

namespace Supermarket\Renderer;

use Supermarket\Model\View\CartContentView;
use Supermarket\Model\View\TotalListView;
use Supermarket\Model\View\ProductDetailsView;
use Supermarket\Model\View\ProductListView;

interface Renderer
{
    public function renderProductListTable(
        ProductListView $products,
        string $listItemTemplate,
        string $listContainerTemplate
    ): string;

    public function renderProductDetails(ProductDetailsView $product, string $productDetailsTemplate): string;

    public function renderCart(
        CartContentView $cartItemsView,
        TotalListView $totalListView,
        string $cartItemsTemplate,
        string $totalsTemplate,
        string $cartItemsContainerTemplate
    ): string;

    public function renderEmptyCart(string $template);
}
