<?php

namespace Supermarket\Datastore;

use PDO;

class ProductDatabase implements ProductRepository
{
    public function getAllProducts(PDO $mySqlConnection): array
    {
        $fetchProducts = $mySqlConnection->prepare('select * from products');
        $fetchProducts->execute();
        $products = $fetchProducts->fetchAll(PDO::FETCH_ASSOC);
        $productList = [];
        foreach ($products as $product) {
            $productList [] = new Product($product['id'], $product['name'], $product['price'], $product['type']);
        }
        return $productList;
    }

    public function getProductById(int $id, PDO $mySqlConnection): array
    {
        $fetchProduct = $mySqlConnection->prepare('select * from products where id=?');
        $fetchProduct->execute([$id]);
        $fetchedProduct = $fetchProduct->fetch();
        $product[] = new Product($fetchedProduct['id'], $fetchedProduct['name'], $fetchedProduct['price'],
            $fetchedProduct['type']);
        return $product;
    }
}
