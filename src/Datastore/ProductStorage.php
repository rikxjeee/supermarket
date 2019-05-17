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

    /**
     * @return string
     */
    public function getProductList(): string
    {
        $string ='';
        $productList = $this->getAll();

        foreach ($productList as $key => $product) {
            $string .= ($key + 1) . ': ' . $product->getName() . ' £' . $product->getPrice() . PHP_EOL;
        }
        return $string;
    }

    public function addProduct(Product $product)
    {
        $mySqlConnection = new PDO(...$this->credentials->getCredentials());
        $query = 'insert into products (name, price, type) values (?, ?, ?)';
        $addProduct = $mySqlConnection->prepare($query);
        $addProduct->execute([$product->getName(), $product->getPrice(), $product->getType()]);
    }

    public function deleteProduct($id)
    {
        $mySqlConnection = new PDO(...$this->credentials->getCredentials());
        $query = 'delete from products where id=?';
        $delete = $mySqlConnection->prepare($query);
        $delete->execute([$id]);
    }

    public function modifyProduct(Product $product, int $id)
    {
        $mySqlConnection = new PDO(...$this->credentials->getCredentials());
        $query = 'update products set name=?, price=?, type=? where id=?';
        $updateProduct = $mySqlConnection->prepare($query);
        $updateProduct->execute([$product->getName(), $product->getPrice(), $product->getType(), $id]);
    }
}