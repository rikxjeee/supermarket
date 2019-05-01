<?php

namespace Load\classes;

class Cart
{
    const CRISPS_PRICE = 0.75;
    const DRINK_PRICE = 0.8;
    const SANDWICH_PRICE = 2;
    const MENU_PRICE = 3;
    const DOUBLE_CRISP_PRICE = 1;

    public function calculatePrice(array $param)
    {
        echo $this->calculate($param);
    }

    private function calculate($ShopCart)
    {
        $sum = 0.0;
        $menus = min($ShopCart);
        foreach ($ShopCart as &$CartItems) {
            $CartItems -= $menus;
        };

        unset($CartItems);

        if (($ShopCart["Crisps"] % 2) == 1) {
            $sum += self::CRISPS_PRICE;
            $ShopCart["Crisps"] -= 1;
            $sum += ($ShopCart["Crisps"] / 2) * self::DOUBLE_CRISP_PRICE;
        } else {
            $sum += ($ShopCart["Crisps"] / 2) * self::DOUBLE_CRISP_PRICE;
        };

        if (date("l") == "Monday") {
            $sum += $ShopCart["Drink"] * self::DRINK_PRICE / 2;
        } else {
            $sum += $ShopCart["Drink"] * self::DRINK_PRICE;
        }
        $sum += $ShopCart["Sandwich"] * self::SANDWICH_PRICE;
        $sum += $menus * self::MENU_PRICE;
        return $sum;

    }
}
