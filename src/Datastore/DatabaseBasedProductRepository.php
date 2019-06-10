<?php

namespace Supermarket\Datastore;

use Exception;
use PDO;
use PDOException;
use Supermarket\Exception\InvalidArgumentException;
use Supermarket\Exception\ProductNotFoundException;

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

    /**
     * @throws PDOException
     * @throws InvalidArgumentException
     */
    public function getAllProducts(): array
    {
        $productList = [];
        $fetchProducts = $this->mySqlConnection->prepare('select * from products');
        $fetchProducts->execute();
        $products = $fetchProducts->fetchAll(PDO::FETCH_ASSOC);
        foreach ($products as $product) {
            $productList[] = Product::createFromArray($product);
        }

        return $productList;
    }

    /**
     * @param int $id
     * @return Product
     * @throws Exception
     * @throws PDOException
     */
    public function getProductById(int $id): Product
    {
        $fetchProduct = $this->mySqlConnection->prepare('select * from products where id=?');
        $fetchProduct->execute([$id]);
        $fetchedProduct = $fetchProduct->fetch();
        if (!$fetchedProduct){
            throw new ProductNotFoundException('No such product.');
        }
        $product = Product::createFromArray($fetchedProduct);

        return $product;
    }
}

