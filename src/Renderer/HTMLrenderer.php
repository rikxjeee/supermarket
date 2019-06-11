<?php

namespace Supermarket\Renderer;

use Supermarket\Model\TemplateConfig;
use Supermarket\Model\View\ProductDetailsView;
use Supermarket\Model\View\ProductListView;
use Supermarket\Model\View\ProductListView\Item;

class HTMLrenderer implements Renderer
{
    private $templateConfig;

    public function __construct(TemplateConfig $templateConfig)
    {
        $this->templateConfig = $templateConfig;
    }

    public function renderProductListTable(ProductListView $productList, string $template, string $tableTemplate): string
    {
        $table = file_get_contents($this->templateConfig->getBasePath() . $tableTemplate);
        $list = '';
        foreach ($productList->getItems() as $product) {
            $list .= $this->renderProductList($product, $this->templateConfig->getBasePath() . $template);
        }
        $list = str_replace('%PRODUCTS%', $list, $table);

        return $this->renderWebPage($list, 'index.html');
    }

    public function renderProductDetails(ProductDetailsView $product, string $productDetailsTemplate): string
    {
        $content = file_get_contents($this->templateConfig->getBasePath() . $productDetailsTemplate);
        $content = str_replace('%NAME%', $product->getName(), $content);
        $content = str_replace('%PRICE%', $product->getPrice(), $content);
        $content = str_replace('%TYPE%', $product->getType(), $content);
        $content = str_replace('%DESCRIPTION%', $product->getDescription(), $content);

        return $this->renderWebPage($content, 'index.html');
    }

    private function renderProductList(Item $product, string $template): string
    {
        $list = file_get_contents($template);
        $list = str_replace('%URL%', $product->getUrl(), $list);
        $list = str_replace('%NAME%', $product->getName(), $list);
        $list = str_replace('%PRICE%', $product->getPrice(), $list);
        $list = str_replace('%TYPE%', $product->getType(), $list);

        return $list;
    }

    private function renderWebPage(string $content, string $template): string
    {
        $index = file_get_contents($this->templateConfig->getBasePath() . $template);

        return str_replace('%CONTENT%', $content, $index);
    }
}
