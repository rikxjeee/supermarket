<?php

namespace App\Service\Calculator;


use App\Entity\CartItem;
use App\Entity\Total;
use App\Service\Provider\DiscountProvider;

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
            $quantity = $item->getQuantity();
            $price = $item->getProduct()->getPrice()*$quantity;

            if ($this->discountProvider->isSoftDrinkDiscountApplies() && ($item->getProduct()->isSoftDrink()) && $item->getQuantity() > 1) {
                $currentItems[] = new CartItem($item->getProduct(), $item->getQuantity());
                $remainingItems = array_udiff($cartItems, $currentItems, function (CartItem $first, CartItem $second) {
                    if ($first->getProduct()->getId() === $second->getProduct()->getId()) {

                        return 1;
                    }

                    return 0;
                });

                return new Total('Soft Drink discount:', -($price/2), $remainingItems);
            }
        }

        return new Total('Soft Drink discount:', $sum, $cartItems);
    }

    public function getType(): string
    {
        return 'SoftDrink';
    }
}
