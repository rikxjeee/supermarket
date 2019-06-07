<?php

namespace Supermarket\Datastore;

interface ProductRepository
{
    public function getAllProducts();
    public function getProductById(int $id);
}
