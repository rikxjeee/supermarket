<?php

namespace App\Repository;

use App\Entity\Cart;

interface CartRepository
{
    public function getCart(int $id): Cart;

    /**
     * @param Cart $cart
     **/
    public function save(Cart $cart): void;
}
