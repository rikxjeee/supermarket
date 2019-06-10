<?php

namespace Supermarket\Datastore;

use Exception;
use PDOException;

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
     */
    public function getProductById(int $id): Product;
}
