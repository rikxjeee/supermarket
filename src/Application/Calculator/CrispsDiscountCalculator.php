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
        //var_dump($cartCartItems);
        $sum = 0;
        $quantity = 0;
        $remainingItems = [];
        foreach ($cartCartItems as $item) {

            if ($item->getProduct()->isCrisp()) {
                $quantity += $item->getQuantity();

                $currentItems[] = new CartItem($item->getProduct(), $quantity);
                $remainingItems = array_udiff($cartCartItems, $currentItems,
                    function (CartItem $first, CartItem $second) {
                        if ($first->getProduct()->getId() === $second->getProduct()->getId()) {
                            return 1;
                        }

                        return 0;
                    });

                $sum += $item->getProduct()->getPrice() * $item->getQuantity();
            }
        }
        if ($quantity / 2 < 1) {
            return new Total('Crisps discount', 0, $remainingItems);
        } else {
            $amount = round($quantity / 2) * 1;
        }
        return new Total('Crisps discount', -($sum - $amount), $remainingItems);
    }
}
