<?php

namespace Supermarket\Application\Calculator;

use Supermarket\Model\Cart;
use Supermarket\Model\CartItem;
use Supermarket\Model\Total;

interface Calculator
{
    /**
     * @param array $cartItem
     *
     * @return Total
     */
    public function getTotal(array $cartItem): Total;
}
