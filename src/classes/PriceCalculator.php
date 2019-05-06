<?php


namespace Load\classes;


class PriceCalculator
{
    const MENU_PRICE = 3;
    const DOUBLE_CRISP_PRICE = 1;
    const MENU_ITEMS = [ 'Crisps', 'Drink', 'Sandwich'];

    /**
     * @param CartItem[] $cartItems
     * @return float
     */
    public function calculateTotal(array $cartItems): float
    {
        $menus = $this->getNumberOfMenus($cartItems);
        $sum = $menus * self::MENU_PRICE;

        foreach ($cartItems as $cartItem) {
            $price = $cartItem->getPrice();

            $quantity = $cartItem->getQuantity();
            if (in_array($cartItem->getProduct()->getName(), self::MENU_ITEMS)){
                $quantity -=$menus;
            }

            $sum += $price * $quantity;
        }

        $sum -= $this->calculateDiscount($cartItems);
        return $sum;
    }

    /**
     * @param CartItem[] $cartItems
     * @return float
     */
    public function calculateDiscount(array $cartItems): float
    {
        $discount = 0;
        $menus = $this->getNumberOfMenus($cartItems);

        foreach ($cartItems as $cartItem) {
            $price = $cartItem->getPrice();

            $quantity = $cartItem->getQuantity();
            if (in_array($cartItem->getProduct()->getName(), self::MENU_ITEMS)){
                $quantity -=$menus;
            }
            if (date('l' == 'Monday') && $cartItem->getProduct()->getName() == 'Drink'){
                $discount += $price/2;
            }

            if ($cartItem->getProduct()->getName() == 'Crisps'){
                $discount += ((int)($quantity / 2))* 0.5;
            }
        }

        return $discount;
    }

    /**
     * @param CartItem[] $cartItems
     * @return int
     */
    private function getNumberOfMenus(array $cartItems): int
    {
        $minimum = null;
        foreach ($cartItems as $cartItem){
            if(!in_array($cartItem->getProduct()->getName(), self::MENU_ITEMS)) {
                continue;
            }

            if ($minimum === null || $cartItem->getQuantity() <= $minimum) {
                $minimum = $cartItem->getQuantity();
            }
        }
        return (int)$minimum;
    }
}