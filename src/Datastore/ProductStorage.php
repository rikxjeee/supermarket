<?php


namespace Supermarket\Datastore;

use PDO;

class ProductStorage
{
    private $credentials;
    private $itemList;

    public function __construct()
    {
        $this->credentials = new Credentials();
    }

    public function getAllProducts()
    {
        $mySqlConnection = new PDO(...$this->credentials->getCredentials());
        $fetchProducts = $mySqlConnection->prepare('select * from products');
        $fetchProducts->execute();
        $productsArray = $fetchProducts->fetchAll(PDO::FETCH_ASSOC);
        $this->itemList = $productsArray;
        $productList = '';
        foreach ($this->itemList as $item) {
            $product = file_get_contents('./src/Template/Product.html');
            $product = str_replace('%ID%', $item['id'], $product);
            $product = str_replace('%NAME%', $item['name'], $product);
            $product = str_replace('%PRICE%', $item['price'], $product);
            $product = str_replace('%TYPE%', $item['type'], $product);
            $productList .= $product;
        }
        return $productList;
    }

    public function getProductById(int $id)
    {
        $mySqlConnection = new PDO(...$this->credentials->getCredentials());
        $fetchProduct = $mySqlConnection->prepare('select * from products where id=?');
        $fetchProduct->execute([$id]);
        $product = $fetchProduct->fetch();
        $productTemplate = file_get_contents('./src/Template/Product.html');
        $productTemplate = str_replace('%ID%', $product['id'], $productTemplate);
        $productTemplate = str_replace('%NAME%', $product['name'], $productTemplate);
        $productTemplate = str_replace('%PRICE%', $product['price'], $productTemplate);
        $productTemplate = str_replace('%TYPE%', $product['type'], $productTemplate);

        return $productTemplate. '<br><a href="index.php">Back</a>';
    }
}