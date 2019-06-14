<?php

namespace Supermarket\Renderer;

use Supermarket\Model\Config\ApplicationConfig\TemplateConfig;
use Supermarket\Model\View\CartContentView;
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

    private function renderTemplate(array $data, string $content): string
    {
        foreach ($data as $key => $value) {
            $content = str_replace(sprintf('{{%s}}', $key), $value, $content);
        }

        return $content;
    }

    private function loadTemplate(string $template): string
    {
        return file_get_contents($this->templateConfig->getBasePath() . $template);
    }

    public function renderProductDetails(ProductDetailsView $product, string $productDetailsTemplate): string
    {
        $content = $this->renderTemplate($product->toArray(), $this->loadTemplate($productDetailsTemplate));

        return $this->renderTemplate(['content' => $content], $this->loadTemplate('index.html'));
    }

    public function renderCart(
        CartContentView $cartContentView,
        string $cartItemsTemplate,
        string $cartItemsContainerTemplate,
        string $emptyCartTemplate
    ): string {

        if (empty($cartContentView->getItems())) {
            return $this->renderTemplate(
                ['content' => $this->loadTemplate($emptyCartTemplate)],
                $this->loadTemplate('index.html'));
        }

        $list = '';
        foreach ($cartContentView->getItems() as $item) {
            $list .= $this->renderTemplate($item->toArray(), $this->loadTemplate($cartItemsTemplate));
        }
        $list = $this->renderTemplate(['cartitems' => $list], $this->loadTemplate($cartItemsContainerTemplate));
        $list = $this->renderTemplate(['content' => $list], $this->loadTemplate('index.html'));

        return $list;
    }

    public function renderEmptyCart(string $template)
    {
        return $this->loadTemplate($template);
    }
}
