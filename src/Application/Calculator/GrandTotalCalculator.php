<?php

namespace Supermarket\Application\Calculator;

use Supermarket\Model\Cart;
use Supermarket\Model\CartItem;
use Supermarket\Model\Total;

class GrandTotalCalculator
{
    /** @var Calculator[] */
    private $calculators;

    public function __construct(array $calculators)
    {
        $this->calculators = $calculators;
    }

    public function getTotal(Cart $cart): array
    {
        $currentRemainingItems = $cart->getItems();
        $sum = 0;
        foreach ($this->calculators as $calculator) {
            $sum += $calculator->getTotal($currentRemainingItems)->getSum();
            $currentTotal = $calculator->getTotal($currentRemainingItems);
            $currentRemainingItems = $currentTotal->getRemainingItems();
            if ($currentTotal->getSum() != 0) {
                $totals[$currentTotal->getType()] = $currentTotal;
            }
        }
        $totals['Grand Total'] = new Total('Grand total', $sum);

        return $totals;
    }
}
