<?php


namespace Load\classes;

use PDO;

class ProductStorage
{
    /**
     * @var array
     */
    private $itemList;

    /**
     * @return Product[]
     */
    public function getAll(): array
    {
        $credentials = new Credentials();
        $mySqlConnection = new PDO(...$credentials->getCredentials());

        $fetchProducts = $mySqlConnection->prepare('select * from products');
        $fetchProducts->execute();
        $productsArray = $fetchProducts->fetchAll(PDO::FETCH_ASSOC);
        $this->itemList = $productsArray;
        $productList = [];
        foreach ($this->itemList as $item) {
            $productList[] = new Product($item['id'], $item['name'], $item['price'], $item['type']);
        }
        return $productList;
    }


    public function addProduct(string $name, float $price, string $type)
    {
        $credentials = new Credentials();
        $mySqlConnection = new PDO(...$credentials->getCredentials());

        $query = 'insert into products (name, price, type) values (?, ?, ?)';
        $product = $mySqlConnection->prepare($query);
        $product->execute([$name, $price, $type]);
    }

    public function updatePrice(float $price, int $id)
    {
        $credentials = new Credentials();
        $mySqlConnection = new PDO(...$credentials->getCredentials());

        $query = 'update products set price=? where id=?';
        $updatedPrice = $mySqlConnection->prepare($query);
        $updatedPrice->execute([$price, $id]);
    }

    public function deleteProduct($id)
    {
        $credentials = new Credentials();
        $mySqlConnection = new PDO(...$credentials->getCredentials());

        $query = 'delete from products where id=?';
        $delete = $mySqlConnection->prepare($query);
        $delete->execute($id);
    }
}