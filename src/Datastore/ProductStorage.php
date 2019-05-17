<?php

namespace Supermarket\Datastore;

use PDO;
use Supermarket\Product;

class ProductStorage
{
    /**
     * @var array
     */
    private $itemList;

    private $credentials;

    /**
     * ProductStorage constructor.
     * @param Credentials $credentials
     */
    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    /**
     * @return Product[]
     */
    public function getAll(): array
    {
        $mySqlConnection = new PDO(...$this->credentials->getCredentials());

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
        $mySqlConnection = new PDO(...$this->credentials->getCredentials());

        $query = 'insert into products (name, price, type) values (?, ?, ?)';
        $product = $mySqlConnection->prepare($query);
        $product->execute([$name, $price, $type]);
    }

    public function updatePrice(float $price, int $id)
    {
        $mySqlConnection = new PDO(...$this->credentials->getCredentials());

        $query = 'update products set price=? where id=?';
        $updatedPrice = $mySqlConnection->prepare($query);
        $updatedPrice->execute([$price, $id]);
    }

    public function deleteProduct($id)
    {
        $mySqlConnection = new PDO(...$this->credentials->getCredentials());

        $query = 'delete from products where id=?';
        $delete = $mySqlConnection->prepare($query);
        $delete->execute([$id]);
    }
}