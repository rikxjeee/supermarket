<?php

namespace Supermarket\Application;

use Supermarket\Model\Cart;
use Supermarket\Model\Total;

class FullPriceCalculator implements Calculator
{
    public function getTotal(Cart $cart): Total
    {
        $sum = 0;
        foreach ($cart->getItems() as $item) {
            $sum += $item->getProduct()->getPrice() * $item->getQuantity();
        }

        return new Total('fullprice', $sum);
    }
}
