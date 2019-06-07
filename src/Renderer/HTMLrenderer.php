<?php

namespace Supermarket\Renderer;

use Supermarket\Datastore\Product;

class HTMLrenderer implements Renderer
{
    /**
     * @param Product[] $products
     * @return string
     */
    public function renderProductList(array $products): string
    {
        $product = '';
        foreach ($products as $item) {
            $product .= file_get_contents('./src/Template/Product.html');
            $product = str_replace('%ID%', $item->getId(), $product);
            $product = str_replace('%NAME%', $item->getName(), $product);
            $product = str_replace('%PRICE%', $item->getPrice(), $product);
            $product = str_replace('%TYPE%', $item->getType(), $product);
        }
        return $product;
    }
}
