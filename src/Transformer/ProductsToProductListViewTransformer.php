<?php

namespace Supermarket\Transformer;

use Supermarket\Model\View\ProductListView\Item;
use Supermarket\Model\Product;
use Supermarket\Model\View\ProductListView;

class ProductsToProductListViewTransformer
{
    /**
     * @param Product[] $products
     * @return ProductListView
     */
    public function transform(array $products): ProductListView
    {
        $productListView = [];
        foreach ($products as $product){
            $productListView[] = new Item(
                'index.php?page=details&id='.$product->getId(),
                $product->getName(),
                $product->getPrice(),
                $product->getType()
            );
        }
        return new ProductListView($productListView);
    }
}
