<?php


namespace Load\classes;


class PriceCalculator
{

    const MENU_ITEMS = [ Product::TYPE_SANDWICH, Product::TYPE_SOFT_DRINK, Product::TYPE_CRISP];

    /**
     * @param CartItem[] $cartItems
     * @return float
     */
    public function calculateTotal(array $cartItems): float
    {
        $sum = 0.0;

        foreach ($cartItems as $cartItem) {
            $price = $cartItem->getPrice();
            $quantity = $cartItem->getQuantity();
            $sum += $price * $quantity;
        }

        foreach ($this->calculateDiscount($cartItems) as $item){
            $sum -= $item['amount'];
        }
        return $sum;
    }

    /**
     * @param CartItem[] $cartItems
     * @return array
     */
    public function calculateDiscount(array $cartItems): array
    {
        $discounts = [];
        $menuDiscounts = $this->getMenuDiscount($cartItems);
        $remainingItems = $cartItems;
        if (!empty($menuDiscounts)) {
            $discounts[] = $menuDiscounts;
            $remainingItems = $menuDiscounts['remainingItems'];
        }

        $softDrinkDiscount = $this->getSoftDrinkDiscount($remainingItems);
        if (!empty($softDrinkDiscount)) {
            $discounts[] = $softDrinkDiscount;
        }

        $crispsDiscount = $this->getCrispsDiscount($remainingItems);

        if (!empty($crispsDiscount)) {
            $discounts[] = $crispsDiscount;
        }

        return $discounts;
    }

    /**
     * @param CartItem[] $cartItems
     * @return int
     */
    private function getNumberOfMenus(array $cartItems): int
    {
        $minimum = null;
        foreach ($cartItems as $cartItem){
            if(!in_array($cartItem->getProduct()->getType(), self::MENU_ITEMS)) {
                continue;
            }

            if ($minimum === null || $cartItem->getQuantity() <= $minimum) {
                $minimum = $cartItem->getQuantity();
            }
        }
        return (int)$minimum;
    }

    /**
     * @param array $cartItems
     * @return array
     */
    private function getMenuDiscount(array $cartItems): array
    {
        $discount = [];
        $menuItemTotal =0;
        $menus = $this->getNumberOfMenus($cartItems);
        $remainingCartItems = [];

        foreach ($cartItems as $cartItem){
            $remainingQuantity = $cartItem->getQuantity();
            if(in_array($cartItem->getProduct()->getType(), self::MENU_ITEMS)) {
                $menuItemTotal += $cartItem->getPrice()*$menus;
                $remainingQuantity -= $menus;
            }
            if ($remainingQuantity > 0){
                $remainingCartItems[] = new CartItem($cartItem->getProduct(), $remainingQuantity);
            }
        }

        $amount = $menuItemTotal-$menus*3;
        if ($amount > 0) {
            $discount = [
                'name' => 'Menu',
                'amount' => $amount,
                'remainingItems' => $remainingCartItems
            ];
        }
        return $discount;
    }

    /**
     * @param $cartItems
     * @return array
     */
    private function getSoftDrinkDiscount($cartItems): array
    {
        $discount = [];
        foreach ($cartItems as $cartItem) {
            $price = $cartItem->getPrice();
            $quantity = $cartItem->getQuantity();


            if (date('l') == 'Monday' && $cartItem->getProduct()->isSoftDrink()) {
                $discount = [
                    'name' => 'Drinks',
                    'amount' => $quantity * ($price / 2)
                ];
            }

        }
        return $discount;
    }



    private function getCrispsDiscount($cartItems): array
    {
        $discount = [];
        foreach ($cartItems as $cartItem) {
            $quantity = $cartItem->getQuantity();

            if ($cartItem->getProduct()->isCrisp()){
                $amount = ((int)($quantity / 2))* 0.5;
                if ($amount > 0) {
                    $discount = [
                        'name' => 'Crisps',
                        'amount' => ((int)($quantity / 2)) * 0.5
                    ];
                }
            }

        }
        return $discount;
    }
}