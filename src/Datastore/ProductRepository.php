<?php

namespace Supermarket\Datastore;

use Exception;
use PDOException;
use Supermarket\Exception\ProductNotFoundException;

interface ProductRepository
{
    /**
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
