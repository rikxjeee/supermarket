<?php

namespace Supermarket\Transformer;

use Supermarket\Model\Product;
use Supermarket\Model\View\ProductDetailsView;
use Supermarket\Provider\UrlProvider;

class ProductToProductDetailsViewTransformer
{
    /**
     * @var UrlProvider
     */
    private $urlProvider;

    public function __construct(UrlProvider $urlProvider)
    {
        $this->urlProvider = $urlProvider;
    }

    public function transform(Product $product): ProductDetailsView
    {
        return new ProductDetailsView(
            $product->getId(),
            $product->getName(),
            $product->getPrice(),
            $product->getType(),
            $product->getDescription(),
            $this->urlProvider->getProductListUrl(),
            $this->urlProvider->getAddToCartUrl()
        );
    }
}
