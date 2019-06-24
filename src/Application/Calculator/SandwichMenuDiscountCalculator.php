<?php

namespace Supermarket\Application\Calculator;

use Supermarket\Model\CartItem;
use Supermarket\Model\Product;
use Supermarket\Model\Total;

class SandwichMenuDiscountCalculator implements Calculator
{
    const MENU_ITEMS = [Product::TYPE_SANDWICH, Product::TYPE_SOFT_DRINK, Product::TYPE_CRISP];

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
        foreach ($cartItems as $cartItem) {
            $remainingQuantity = $cartItem->getQuantity();
            if (in_array($cartItem->getProduct()->getType(), self::MENU_ITEMS)) {
                $menuItemTotal += $cartItem->getPrice() * $menus;
                $remainingQuantity -= $menus;
            }
            if ($remainingQuantity > 0) {
                $remainingCartItems[] = new CartItem($cartItem->getProduct(), $remainingQuantity);
            }
        }
        $amount = $menuItemTotal - $menus * 3;

        return new Total('Sandwich menu', -$amount, $remainingCartItems);
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
            if (!in_array($cartItem->getProduct()->getType(), self::MENU_ITEMS)) {
                continue;
            }
            $menu[$cartItem->getProduct()->getType()] = true;
            if ($minimum === null || $cartItem->getQuantity() <= $minimum) {
                $minimum = $cartItem->getQuantity();
            }
        }
        foreach (self::MENU_ITEMS as $MENU_ITEM) {
            if (!isset($menu[$MENU_ITEM])) {
                return 0;
            }
        }

        return $minimum;
    }
}
