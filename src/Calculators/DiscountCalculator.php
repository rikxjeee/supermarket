<?php


namespace Supermarket\Calculators;


use Supermarket\Cart\CartItem;
use Supermarket\Product;
use Supermarket\Total;

class DiscountCalculator
{

    const MENU_ITEMS = [Product::TYPE_SANDWICH, Product::TYPE_SOFT_DRINK, Product::TYPE_CRISP];

    /**
     * @param $cartItems []
     * @return Total
     */
    public function getTotal($cartItems): Total
    {
        $sum = 0;
        $items = $this->calculateDiscount($cartItems);
        foreach ($items as $item) {
            $sum -= $item->getPrice();
        }
        return new Total('Total discounts:', $sum);
    }

    /**
     * @param $cartItems
     * @return array
     */
    public function getDiscountedItems($cartItems)
    {
        return $this->calculateDiscount($cartItems);
    }

    /**
     * @param CartItem[] $cartItems
     * @return array
     */
    private function calculateDiscount(array $cartItems): array
    {
        $discounts = [];
        $menuDiscounts = $this->getMenuDiscount($cartItems);
        $remainingItems = $cartItems;
        if (!empty($menuDiscounts)) {
            $discounts[] = $menuDiscounts;
            $remainingItems = $menuDiscounts->getRemainingItems();
        }
        $generalDiscount = $this->getGeneralDiscount($remainingItems);
        if (!empty($generalDiscount)) {
            $discounts = array_merge($discounts, $generalDiscount);
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
        $menu = [];
        foreach ($cartItems as $cartItem) {
            if (!in_array($cartItem->getProduct()->getType(), self::MENU_ITEMS)){
                continue;
            }
                $menu[$cartItem->getProduct()->getType()] = true;
                if ($minimum === null || $cartItem->getQuantity() <= $minimum) {
                $minimum = $cartItem->getQuantity();
            }

        }
        foreach (self::MENU_ITEMS as $MENU_ITEM) {
                if (!isset($menu[$MENU_ITEM])){
                    return 0;
                }
        }
            return (int)$minimum;
    }

    /**
     * @param array $cartItems
     * @return Total|null
     */
    private function getMenuDiscount(array $cartItems): ?Total
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
        if ($amount > 0) {
            return new Total('Sandwich menu', $amount, $remainingCartItems);
        }
        return null;
    }

    /**
     * @param CartItem[] $cartItems
     * @return array
     */
    private function getGeneralDiscount($cartItems): array
    {
        $discount = [];
        foreach ($cartItems as $cartItem) {
            $price = $cartItem->getPrice();
            $quantity = $cartItem->getQuantity();

            if ((date('l') == 'Monday') && ($cartItem->getProduct()->isSoftDrink())) {
                $discount[] =
                    new Total($cartItem->getProduct()->getName(), $quantity * ($price / 2));
            }
            if ($cartItem->getProduct()->isCrisp()) {
                $amount = ((int)($quantity / 2)) * 0.5;
                if ($amount > 0) {
                    $discount[] =
                        new Total(Product::TYPE_CRISP, ((int)($quantity / 2)) * 0.5);
                }
            }
        }
        return $discount;
    }
}