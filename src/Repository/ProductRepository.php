<?php

namespace App\Repository;

use App\Entity\Product;
use App\Exception\ProductNotFoundException;

interface ProductRepository
{
    /**
     * @return Product[]
     */
    public function getAllProducts(): array;

    /**
     * @param int $id
     *
     * @return Product
     *@throws ProductNotFoundException
     */
    public function getProductById(int $id): Product;

    public function save(Product $product): void;
}
