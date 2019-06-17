<?php

namespace Supermarket\Repository;

use Supermarket\Model\Cart;

interface CartRepository
{
    public function getById(int $id): Cart;
}
