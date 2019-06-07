<?php

namespace Supermarket;

use PDO;
use Supermarket\Datastore\Credentials;
use Supermarket\Datastore\ProductRepository;
use Supermarket\Renderer\Renderer;

class Supermarket
{
    public $productStorage;
    private $database;
    private $renderer;

    public function __construct(Credentials $credentials, ProductRepository $productStorage, Renderer $renderer)
    {
        $this->productStorage = $productStorage;
        $this->database = new PDO(...$credentials->getCredentials());
        $this->renderer = $renderer;
    }

    public function getProductList(): string
    {
        $productListTemplate = file_get_contents('./src/Template/ProductList.html');
        $products = $this->productStorage->getAllProducts($this->database);
        $productList = $this->render($this->renderer, $products);
        return str_replace('%PRODUCTS%', $productList, $productListTemplate);
    }

    public function getSingleProduct(int $id): string
    {
        $product = $this->productStorage->getProductById($id, $this->database);
        return '<table>'.$this->render($this->renderer, $product).'</table><br><a href="index.php">Back</a>';
    }

    private function render(Renderer $render, array $product)
    {
        return $render->renderProductList($product);
    }
}
