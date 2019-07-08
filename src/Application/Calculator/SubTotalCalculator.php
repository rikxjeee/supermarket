<?php

namespace Supermarket\Application\Calculator;

use Supermarket\Model\Cart;
use Supermarket\Model\CartItem;
use Supermarket\Model\Total;

class SubTotalCalculator implements Calculator
{
    public function getTotal(array $cartItems): Total
    {
        $sum = 0;
        foreach ($cartItems as $item) {
            $sum += $item->getProduct()->getPrice() * $item->getQuantity();
        }

        return new Total('Subtotal:', $sum, $cartItems);
    }
}
