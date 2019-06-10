<?php

namespace Supermarket\Datastore;

interface ProductRepository
{
    public function getAllProducts(): array;
    public function getProductById(int $id): Product;
}
