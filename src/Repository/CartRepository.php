<?php

namespace Supermarket\Repository;

use Supermarket\Exception\CouldNotSaveException;
use Supermarket\Model\Cart;

interface CartRepository
{
    public function getById(int $id): Cart;

    /**
     * @param Cart $cart
     *
     * @throws CouldNotSaveException
     */
    public function save(Cart $cart): void;
}
