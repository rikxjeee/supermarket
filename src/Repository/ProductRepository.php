<?php

namespace Supermarket\Repository;

use Exception;
use PDOException;
use Supermarket\Exception\ProductNotFoundException;
use Supermarket\Model\Product;

interface ProductRepository
{
    /**
     * @return Product[]
     * @throws PDOException
     */
    public function getAllProducts(): array;

    /**
     * @param int $id
     * @return Product
     * @throws Exception
     * @throws PDOException
     * @throws ProductNotFoundException
     */
    public function getProductById(int $id): Product;
}
