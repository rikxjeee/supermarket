<?php

namespace Supermarket\Renderer;

use Supermarket\Model\Config\ApplicationConfig\TemplateConfig;
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

    public function renderProductListTable(
        ProductListView $productList,
        string $listItemTemplate,
        string $listContainerTemplate
    ): string
    {
        $list = '';
        foreach ($productList->getItems() as $product) {
            $list .= $this->renderProductList($product, $this->loadTemplate($listItemTemplate));
        }
        $list = str_replace('{{products}}', $list, $this->loadTemplate($listContainerTemplate));

        return $this->renderWebPage($list, 'index.html');
    }

    public function renderProductDetails(ProductDetailsView $product, string $productDetailsTemplate): string
    {
        $productData = $product->toArray();
        $content = $this->loadTemplate($productDetailsTemplate);
        foreach ($productData as $key => $value) {
            $content = str_replace(sprintf('{{%s}}', $key), $value, $content);
        }

        return $this->renderWebPage($content, 'index.html');
    }

    private function renderProductList(Item $product, string $template): string
    {
        $productData = $product->toArray();
        $list = $template;
        foreach ($productData as $key => $value) {
            $list = str_replace(sprintf('{{%s}}', $key), $value, $list);
        }

        return $list;
    }

    private function renderWebPage(string $content, string $template): string
    {
        $index = $this->loadTemplate($template);

        return str_replace('{{content}}', $content, $index);
    }

    private function loadTemplate(string $template): string
    {
        return file_get_contents($this->templateConfig->getBasePath() . $template);
    }
}
