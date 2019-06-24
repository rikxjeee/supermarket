<?php

namespace Supermarket\Application\Calculator;

use Supermarket\Model\CartItem;
use Supermarket\Model\Total;

class SoftDrinkDiscountCalculator implements Calculator
{
    /**
     * @param CartItem[] $cartItems
     *
     * @return Total
     */
    public function getTotal(array $cartItems): Total
    {
        $sum = 0;
        foreach ($cartItems as $item) {
            $price = $item->getPrice();
            $quantity = $item->getQuantity();

            if ((date('l') == 'Monday') && ($item->getProduct()->isSoftDrink()) && $item->getQuantity() > 1) {
                $currentItems[] = new CartItem($item->getProduct(), $item->getQuantity());
                $remainingItems = array_udiff($cartItems, $currentItems, function (CartItem $first, CartItem $second) {
                    if ($first->getProduct()->getId() === $second->getProduct()->getId()) {

                        return 1;
                    }

                    return 0;
                });

                return new Total('Soft drink discount', -$quantity * ($price / 2), $remainingItems);
            }
        }

        return new Total('Soft Drink discount', $sum, $cartItems);
    }
}
