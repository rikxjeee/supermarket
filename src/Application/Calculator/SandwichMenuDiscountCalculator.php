<?php

namespace Supermarket\Application\Calculator;

use Supermarket\Model\CartItem;
use Supermarket\Model\Total;

class SandwichMenuDiscountCalculator implements Calculator
{
    /**
     * @param CartItem[] $items
     *
     * @return Total
     */
    public function getTotal(array $items): Total
    {
        $sum = $this->getMenuDiscount();

        return new Total('Sandwich Menu discount', $sum, $items);
    }

    public function getMenuDiscount()
    {
        return -1;
    }
}
