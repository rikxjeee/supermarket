<?php

namespace Supermarket\Renderer;

use Supermarket\Model\Config\ApplicationConfig\TemplateConfig;
use Supermarket\Model\View\ProductDetailsView;
use Supermarket\Model\View\ProductListView;

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
    ): string {
        $list = '';
        foreach ($productList->getItems() as $product) {
            $list .= $this->renderTemplate($product->toArray(), $this->loadTemplate($listItemTemplate));
        }
        $list = $this->renderTemplate(['products' => $list], $this->loadTemplate($listContainerTemplate));

        return $this->renderTemplate(['content' => $list], $this->loadTemplate('index.html'));
    }

    public function renderProductDetails(ProductDetailsView $product, string $productDetailsTemplate): string
    {
        $content = $this->renderTemplate($product->toArray(), $this->loadTemplate($productDetailsTemplate));

        return $this->renderTemplate(['content' => $content], $this->loadTemplate('index.html'));
    }

    private function loadTemplate(string $template): string
    {
        return file_get_contents($this->templateConfig->getBasePath() . $template);
    }

    private function renderTemplate(array $data, string $content): string
    {
        foreach ($data as $key => $value) {
            $content = str_replace(sprintf('{{%s}}', $key), $value, $content);
        }

        return $content;
    }
}
