<?php


namespace Load\classes;


class PriceCalculator
{
    const MENU_PRICE = 3;
    const DOUBLE_CRISP_PRICE = 1;

    public function calculatePrice($cartItems): float
    {
        $sum = 0.0;
        $menus = min($cartItems);
        foreach ($cartItems as &$CartItems) {
            $CartItems -= $menus;
        };

        unset($CartItems);

        $itemProperties = new ItemPropertyProvider();

        if (($cartItems["Crisps"] % 2) == 1) {
            $sum += $itemProperties->itemList['Crisps'];
            $cartItems["Crisps"] -= 1;
            $sum += ($cartItems["Crisps"] / 2) * $itemProperties->itemList['Crisps'];
        } else {
            $sum += ($cartItems["Crisps"] / 2) * self::DOUBLE_CRISP_PRICE;
        };

        if (date("l") == "Monday") {
            $sum += $cartItems["Drink"] * $itemProperties->itemList['Drink'] / 2;
        } else {
            $sum += $cartItems["Drink"] * $itemProperties->itemList['Drink'];
        }
        $sum += $cartItems["Sandwich"] * $itemProperties->itemList['Sandwich'];
        $sum += $menus * self::MENU_PRICE;
        return $sum;
    }
}