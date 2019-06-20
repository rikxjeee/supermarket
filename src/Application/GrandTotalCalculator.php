<?php

namespace Supermarket\Application;

use Supermarket\Model\Cart;
use Supermarket\Model\Total;

class GrandTotalCalculator
{
    /** @var Calculator */
    private $fullPriceCalculator;

    /** @var Calculator */
    private $discountCalculator;

    /**
     * @param Calculator $fullPriceCalculator
     * @param Calculator $discountCalculator
     */
    public function __construct(Calculator $fullPriceCalculator, Calculator $discountCalculator)
    {
        $this->fullPriceCalculator = $fullPriceCalculator;
        $this->discountCalculator = $discountCalculator;
    }

    public function getTotal(Cart $cart): Total
    {
        $fullPrice = $this->getFullPrice($cart)->getSum();
        $discount = $this->getDiscount($cart)->getSum();
        $sum = $fullPrice + $discount;

        return new Total('grandtotal', $sum);
    }

    public function getFullPrice(Cart $cart): Total
    {
        return $this->fullPriceCalculator->getTotal($cart);
    }

    public function getDiscount(Cart $cart): Total
    {
        return $this->discountCalculator->getTotal($cart);
    }
}
