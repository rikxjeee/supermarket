<?php

namespace Supermarket\Calculator;

use Supermarket\Cart\CartItem;

class PriceCalculator
{
    /**
     * @var array
     */
    private $calculators;

    /**
     * PriceCalculator constructor.
     */
    public function __construct()
    {
        $this->calculators = [
            new FullPriceCalculator(),
            new DiscountCalculator()
        ];
    }

    /**
     * @param CartItem[] $cartItems
     * @return float
     */
    public function calculateTotal(array $cartItems): float
    {
        $total = 0;
        foreach ($this->calculators as $calculator) {
            $total += $calculator->getTotal($cartItems)->getPrice();
        }
        return $total;
    }

    public function getTotals(array $cartItems): array
    {
        $totals = [];
        foreach ($this->calculators as $calculator) {
            $totals[] = $calculator->getTotal($cartItems);
        }
        return $totals;
    }
}