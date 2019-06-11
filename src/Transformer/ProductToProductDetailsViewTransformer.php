<?php

namespace Supermarket\Transformer;

use Supermarket\Model\Product;
use Supermarket\Model\View\ProductDetailsView;

class ProductToProductDetailsViewTransformer
{
    public function transform(Product $product): ProductDetailsView
    {
        return new ProductDetailsView(
            $product->getName(),
            $product->getPrice(),
            $product->getType(),
            $product->getDescription()
        );
    }
}
