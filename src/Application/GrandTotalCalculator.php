<?php

namespace Supermarket\Application;

use Supermarket\Model\Cart;
use Supermarket\Model\Total;

class GrandTotalCalculator implements Calculator
{
    /** @var Calculator[] */
    private $calculators;

    public function __construct(array $calculators)
    {
        $this->calculators = $calculators;
    }

    public function getTotal(Cart $cart): Total
    {
        $sum = 0;
        foreach ($this->calculators as $calculator) {
            $sum += $calculator->getTotal($cart)->getSum();
        }

        return new Total('grandtotal', $sum);
    }

    /**
     * @param Cart $cart
     *
     * @return Total[]
     */
    public function getIndividualTotals(Cart $cart): array
    {
        $totals = [];
        foreach ($this->calculators as $calculator) {
            $totals[] = $calculator->getTotal($cart);
        }

        return $totals;
    }
}
