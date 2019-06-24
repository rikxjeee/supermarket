<?php

namespace Supermarket\Application\Calculator;

use Supermarket\Model\CartItem;
use Supermarket\Model\Total;

class CrispsDiscountCalculator implements Calculator
{
    /**
     * @param CartItem[] $cartCartItems
     *
     * @return Total
     */
    public function getTotal(array $cartCartItems): Total
    {
        foreach ($cartCartItems as $item) {
            $quantity = $item->getQuantity();

            if ($item->getProduct()->isCrisp()) {

                $currentItems[] = new CartItem($item->getProduct(), $quantity);
                $remainingItems = array_udiff($cartCartItems, $currentItems, function (CartItem $first, CartItem $second) {
                    if ($first->getProduct()->getId() === $second->getProduct()->getId()) {
                        return 1;
                    }

                    return 0;
                });

                $amount = ($quantity / 2) * 0.5;
                if ($amount > 0) {
                    return new Total('Crisps discount', -$amount, $remainingItems);
                }
            }
        }
        return new Total('Crisps discount', 0, $cartCartItems);
    }
}
