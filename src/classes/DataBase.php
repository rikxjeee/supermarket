<?php


namespace Load\classes;

use PDO;

class DataBase
{
    private $mySqlConnection;

    /**
     * DataBase constructor.
     */
    public function __construct()
    {
        $this->mySqlConnection = new PDO('mysql:host=localhost:9999;dbname=testing', 'root', 'simple');
    }

    /**
     * @return array
     */
    public function fetchAllProducts(): array
    {
        $fetchProducts = $this->mySqlConnection->prepare('select * from products');
        $fetchProducts->execute();
        $productsArray = $fetchProducts->fetchAll(PDO::FETCH_ASSOC);
        return $productsArray;
    }


    public function addProduct(string $name, float $price, string $type)
    {
        $query = 'insert into products (name, price, type) values (?, ?, ?)';
        $product = $this->mySqlConnection->prepare($query);
        $product->execute([$name, $price, $type]);
    }

    public function updatePrice(float $price, int $id)
    {
        $query = 'update products set price=? where id=?';
        $updatedPrice = $this->mySqlConnection->prepare($query);
        $updatedPrice->execute([$price, $id]);
    }

    public function deleteProduct($id)
    {
        $query = 'delete from products where id=?';
        $delete = $this->mySqlConnection->prepare($query);
        $delete->execute($id);
    }
}