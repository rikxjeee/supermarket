<?php

namespace Supermarket\Application\Calculator;

use Supermarket\Model\CartItem;
use Supermarket\Model\Total;
use Supermarket\Provider\DiscountProvider;

class SoftDrinkDiscountCalculator implements Calculator
{
    /** @var DiscountProvider */
    private $discountProvider;

    public function __construct(DiscountProvider $discountProvider)
    {
        $this->discountProvider = $discountProvider;
    }

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

            if ($this->discountProvider->isSoftDrinkDiscountApplies() && ($item->getProduct()->isSoftDrink()) && $item->getQuantity() > 1) {
                $currentItems[] = new CartItem($item->getProduct(), $item->getQuantity());
                $remainingItems = array_udiff($cartItems, $currentItems, function (CartItem $first, CartItem $second) {
                    if ($first->getProduct()->getId() === $second->getProduct()->getId()) {

                        return 1;
                    }

                    return 0;
                });

                return new Total('Soft Drink discount', -($quantity * ($price / 2)), $remainingItems);
            }
        }

        return new Total('Soft Drink discount', $sum, $cartItems);
    }
}
