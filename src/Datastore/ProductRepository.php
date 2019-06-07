<?php

namespace Supermarket\Datastore;

use PDO;

interface ProductRepository
{
    public function getAllProducts(PDO $connection);
    public function getProductById(int $id, PDO $connection);
}
