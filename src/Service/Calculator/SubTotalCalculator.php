<?php

namespace App\Service\Calculator;


use App\Entity\Total;

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

    public function getType(): string
    {
        return 'SubTotal';
    }
}
