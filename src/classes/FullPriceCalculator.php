<?php


namespace Load\classes;


class FullPriceCalculator
{
    /**
     * @param $cartItems []
     * @return Total
     */
    public function getTotal($cartItems): Total
    {
        $sum = 0.0;
        foreach ($cartItems as $cartItem) {
            $price = $cartItem->getPrice();
            $quantity = $cartItem->getQuantity();
            $sum += $price * $quantity;
        }
        return new Total('Subtotal', $sum);
    }
}