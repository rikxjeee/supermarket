<?php

namespace Supermarket\Transformer;

use Supermarket\Model\Product;
use Supermarket\Model\View\ProductListView;
use Supermarket\Model\View\ProductListView\Item;
use Supermarket\Provider\UrlProvider;

class ProductsToProductListViewTransformer
{
    private $urlProvider;

    public function __construct(UrlProvider $urlProvider)
    {
        $this->urlProvider = $urlProvider;
    }

    /**
     * @param Product[] $products
     * @return ProductListView
     */
    public function transform(array $products): ProductListView
    {
        $productListViewData = [];
        foreach ($products as $product){
            $productListViewData[] = new Item(
                $this->urlProvider->getProductUrl($product->getId()),
                $product->getName(),
                $product->getPrice(),
                $product->getType()
            );
        }

        return new ProductListView($productListViewData);
    }
}
