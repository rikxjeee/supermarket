<?php

namespace Supermarket\Datastore;

use PDO;

class DatabaseBasedProductRepository implements ProductRepository
{
    /**
     * @var PDO
     */
    private $mySqlConnection;

    public function __construct(PDO $mySqlConnection)
    {
        $this->mySqlConnection = $mySqlConnection;
    }

    public function getAllProducts(): array
    {
        $fetchProducts = $this->mySqlConnection->prepare('select * from products');
        $fetchProducts->execute();
        $products = $fetchProducts->fetchAll(PDO::FETCH_ASSOC);
        $productList = [];
        foreach ($products as $product) {
            $productList [] = new Product($product['id'], $product['name'], $product['price'], $product['type']);
        }
        return $productList;
    }

    public function getProductById(int $id): Product
    {
        $fetchProduct = $this->mySqlConnection->prepare('select * from products where id=?');
        $fetchProduct->execute([$id]);
        $fetchedProduct = $fetchProduct->fetch();
        $product = new Product($fetchedProduct['id'], $fetchedProduct['name'], $fetchedProduct['price'],
            $fetchedProduct['type']);
        return $product;
    }
}
