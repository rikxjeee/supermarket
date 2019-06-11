<?php

namespace Supermarket\Renderer;

use Supermarket\Datastore\Product;

class HTMLrenderer implements Renderer
{
    private $templateBasePath;

    public function __construct(string $templateBasePath)
    {
        $this->templateBasePath = $templateBasePath;
    }

    public function renderProductListTable(array $products, string $template, string $tableTemplate): string
    {
        $table = file_get_contents($this->templateBasePath . $tableTemplate);
        $list = '';
        foreach ($products as $product) {
            $list .= $this->renderProductList($product, $this->templateBasePath . $template);
        }
        $list = str_replace('%PRODUCTS%', $list, $table);

        return $this->renderWebPage($list, 'index.html');
    }

    public function renderProductDetails(Product $product, string $productDetailsTemplate): string
    {
        $details = $this->renderProductList($product, $this->templateBasePath . $productDetailsTemplate);
        $details = str_replace('%DESCRIPTION%', $product->getDescription(), $details);
        return $this->renderWebPage($details, 'index.html');
    }

    private function renderProductList(Product $product, string $template): string
    {
        $list = file_get_contents($template);
        $list = str_replace('%ID%', $product->getId(), $list);
        $list = str_replace('%NAME%', $product->getName(), $list);
        $list = str_replace('%PRICE%', $product->getPrice(), $list);
        $list = str_replace('%TYPE%', $product->getType(), $list);

        return $list;
    }

    private function renderWebPage(string $content, string $template): string
    {
        $index = file_get_contents($this->templateBasePath . $template);
        return str_replace('%CONTENT%', $content, $index);
    }
}
