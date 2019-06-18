<?php

namespace Supermarket\Repository;

use Exception;
use Supermarket\Exception\ProductNotFoundException;
use Supermarket\Model\Product;

interface ProductRepository
{
    /**
     * @return Product[]
     */
    public function getAllProducts(): array;

    /**
     * @param string $id
     *
     * @return Product
     * @throws Exception
     * @throws ProductNotFoundException
     */
    public function getProductById(string $id): Product;
}
