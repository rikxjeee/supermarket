<?php

namespace Supermarket\Repository;

use Supermarket\Model\Cart;

interface CartRepository
{
    public function getCartById(int $id): Cart;
}
