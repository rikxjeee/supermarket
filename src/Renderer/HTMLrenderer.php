<?php

namespace Supermarket\Renderer;

use Supermarket\Application\SessionManager;
use Supermarket\Model\Config\ApplicationConfig\TemplateConfig;
use Supermarket\Model\View\CartContentView;
use Supermarket\Model\View\ProductDetailsView;
use Supermarket\Model\View\ProductListView;
use Supermarket\Provider\UrlProvider;

class HTMLrenderer implements Renderer
{
    /** @var TemplateConfig */
    private $templateConfig;

    /** @var UrlProvider */
    private $urlProvider;

    /** @var SessionManager */
    private $sessionManager;

    public function __construct(TemplateConfig $templateConfig, UrlProvider $urlProvider, SessionManager $sessionManager)
    {
        $this->templateConfig = $templateConfig;
        $this->urlProvider = $urlProvider;
        $this->sessionManager = $sessionManager;
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

        return $this->renderPage($list);
    }

    public function renderProductDetails(ProductDetailsView $product, string $productDetailsTemplate): string
    {
        $content = $this->renderTemplate($product->toArray(), $this->loadTemplate($productDetailsTemplate));
        return $this->renderPage($content);
    }

    public function renderCart(
        CartContentView $cartContentView,
        string $cartItemsTemplate,
        string $cartItemsContainerTemplate,
        string $emptyCartTemplate
    ): string {

        if (empty($cartContentView->getItems())) {
            return $this->renderEmptyCart($emptyCartTemplate);
        }

        $list = '';
        foreach ($cartContentView->getItems() as $item) {
            $list .= $this->renderTemplate($item->toArray(), $this->loadTemplate($cartItemsTemplate));
        }
        $list = $this->renderTemplate(['cartitems' => $list], $this->loadTemplate($cartItemsContainerTemplate));

        return $this->renderPage($list);
    }

    public function renderEmptyCart(string $template): string
    {
        $data = $this->loadTemplate($template);

        return $this->renderPage($data);
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

    private function renderPage(string $content): string
    {
        $error_message = $this->sessionManager->getValue('error_message');
        $content = [
            'error_message' => $error_message,
            'content' => $content,
            'cartpage' => $this->urlProvider->getCartUrl(),
            'productlistpage' => $this->urlProvider->getProductListUrl()
        ];

        return $this->renderTemplate($content, $this->loadTemplate('index.html'));
    }
}
