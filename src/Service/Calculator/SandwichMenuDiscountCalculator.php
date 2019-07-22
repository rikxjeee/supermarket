<?php

namespace App\Service\Calculator;

use App\Entity\CartItem;
use App\Entity\Total;
use App\Service\Provider\DiscountProvider;

class SandwichMenuDiscountCalculator implements Calculator
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
        $menuItemTotal = 0;
        $menus = $this->getNumberOfMenus($cartItems);
        $remainingCartItems = [];
        $menu = [];
        foreach ($cartItems as $cartItem) {
            $remainingQuantity = $cartItem->getQuantity();
            if (in_array($cartItem->getProduct()->getType(), $this->discountProvider->getMenuItems())) {
                if (!isset($menu[$cartItem->getProduct()->getType()])){
                    $remainingQuantity -= $menus;
                    $menuItemTotal += $cartItem->getProduct()->getPrice() * $menus;
                    $menu[$cartItem->getProduct()->getType()] = true;
                }
            }
            if ($remainingQuantity > 0) {
                $remainingCartItems[] = new CartItem($cartItem->getProduct(), $remainingQuantity);
            }
        }
        $amount = $menuItemTotal - $menus * $this->discountProvider->getMenuPrice();
        return new Total('Sandwich menu:', -$amount, $remainingCartItems);
    }

    /**
     * @param CartItem[] $cartItems
     *
     * @return int
     */
    private function getNumberOfMenus(array $cartItems): int
    {
        $minimum = null;
        $menu = [];
        foreach ($cartItems as $cartItem) {
            if (!in_array($cartItem->getProduct()->getType(), $this->discountProvider->getMenuItems())) {
                continue;
            }
            $menu[$cartItem->getProduct()->getType()] = true;
            if ($minimum === null || $cartItem->getQuantity() <= $minimum) {
                $minimum = $cartItem->getQuantity();
            }
        }
        foreach ($this->discountProvider->getMenuItems() as $MENU_ITEM) {
            if (!isset($menu[$MENU_ITEM])) {
                return 0;
            }
        }

        return $minimum;
    }

    public function getType(): string
    {
        return 'SandwichMenu';
    }
}
