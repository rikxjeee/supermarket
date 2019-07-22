<?php

namespace App\Tests\Behat\Repository;

use App\Entity\Product;
use App\Exception\ProductNotFoundException;
use App\Repository\ProductRepository;

class MemoryBasedProductRepository implements ProductRepository
{
    /** @var Product[] */
    private $products = [];

    /**
     * @return Product[]
     */
    public function getAllProducts(): array
    {
        return $this->products;
    }

    /**
     * @param int $id
     *
     * @return Product
     * @throws ProductNotFoundException
     */
    public function getProductById(int $id): Product
    {
        foreach ($this->products as $product) {
             if ($id === $product->getId()) {
                 return $product;
             }
        }
        throw ProductNotFoundException::createFromId($id);
    }

    /**
     * @param string $name
     *
     * @return Product
     * @throws ProductNotFoundException
     */
    public function getProductByName(string $name): Product
    {
        $id = null;
        foreach ($this->products as $product) {
            if ($product->getName() === $name) {
                $id = $product->getId();
            }
        }
        return $this->getProductById($id);
    }

    public function save(Product $product): void
    {
        $this->products[] = $product;
    }
}
