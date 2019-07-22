<?php

namespace App\Service\Calculator;

use App\Entity\Cart;
use App\Entity\Total;

class GrandTotalCalculator
{
    /** @var Calculator[] */
    private $calculators;

    public function __construct(CalculatorChain $calculatorChain)
    {
        $this->calculators = $calculatorChain;
    }

    public function getTotal(Cart $cart): array
    {
        $calculators = $this->calculators->getCalculators();
        $currentRemainingItems = $cart->getItems();
        $sum = 0;
        foreach ($calculators as $calculator) {
            $sum += $calculator->getTotal($currentRemainingItems)->getSum();
            $currentTotal = $calculator->getTotal($currentRemainingItems);
            $currentRemainingItems = $currentTotal->getRemainingItems();
            if ($currentTotal->getSum() != 0) {
                $totals[$currentTotal->getType()] = $currentTotal;
            }
        }

        $totals['Grand Total'] = new Total('Grand total:', $sum);
        return $totals;
    }
}
