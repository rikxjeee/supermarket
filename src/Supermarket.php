<?php


namespace Supermarket;

use Supermarket\Datastore\ProductStorage;

class Supermarket
{
    public $productStorage;

    public function __construct()
    {
        $this->productStorage = new ProductStorage();
    }

    public function getContent(): string
    {
        $productListTemplate = file_get_contents('./src/Template/ProductList.html');
        return str_replace('%PRODUCTS%', $this->productStorage->getAllProducts(), $productListTemplate);
    }

    public function getSingleProduct($id)
    {
        return $this->productStorage->getProductById($id);
    }
}