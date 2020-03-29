<?php

namespace App\Repository;

use App\Entity\Product;
use App\Exception\ProductNotFoundException;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;

class DatabaseBasedProductRepository implements ProductRepository
{
    /** @var Connection */
    private $dbConnection;

    public function __construct(Connection $databaseConnection)
    {
        $this->dbConnection = $databaseConnection;
    }

    /**
     * @return Product[]
     */
    public function getAllProducts(): array
    {
        $products = $this->dbConnection->fetchAll('select * from product');
        $productList = [];
        foreach ($products as $product) {
            $productList[] = Product::createFromArray($product);
        }

        return $productList;
    }

    /**
     * @param int $id
     *
     * @return Product
     *
     * @throws ProductNotFoundException
     * @throws DBALException
     */
    public function getProductById(int $id): Product
    {
        $query = $this->dbConnection->prepare('select * from product where id=?');
        $query->execute([$id]);
        $productData = $query->fetch();

        if (!$productData) {
            throw ProductNotFoundException::createFromId($id);
        }

        return Product::createFromArray($productData);
    }

    /**
     * @param Product $product
     *
     * @throws DBALException
     */
    public function save(Product $product): void
    {
        $query = $this->dbConnection->prepare(
            'insert into product(name, type, description, price) values (?,?,?,?)'
        );
        $query->execute([
            $product->getName(),
            $product->getType(),
            $product->getDescription(),
            $product->getPrice()
        ]);
    }
}
