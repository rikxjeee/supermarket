<?php

namespace Supermarket\Renderer;

use Supermarket\Datastore\Product;

class HTMLrenderer implements Renderer
{
    /**
     * @param Product[] $products
     * @param string $template
     * @return string
     */
    private function renderProductList(array $products, string $template): string
    {
        $product = '';
        foreach ($products as $item) {
            $product .= file_get_contents($template);
            $product = str_replace('%ID%', $item->getId(), $product);
            $product = str_replace('%NAME%', $item->getName(), $product);
            $product = str_replace('%PRICE%', $item->getPrice(), $product);
            $product = str_replace('%TYPE%', $item->getType(), $product);
        }

        return $product;
    }

    public function renderProductListTable(array $products, string $template): string
    {
        $table = file_get_contents('./src/Template/ProductListTable.html');

        return str_replace('%PRODUCTS%', $this->renderProductList($products, $template), $table);
    }
}
