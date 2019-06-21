<?php

namespace Supermarket\Application\Calculator;

use Supermarket\Model\Cart;
use Supermarket\Model\CartItem;
use Supermarket\Model\Total;

class GrandTotalCalculator
{
    /** @var Calculator[] */
    private $calculators;

    /** @var CartItem[] */
    private $remainingItems;

    public function __construct(array $calculators)
    {
        $this->calculators = $calculators;
    }

    public function getTotal(Cart $cart): array
    {
        $this->remainingItems = $cart->getItems();

        $sum = 0;
        foreach ($this->calculators as $calculator) {
            $sum += $calculator->getTotal($cart->getItems())->getSum();
        }
        $totals[] = new Total('Grand total', $sum);

        foreach ($this->calculators as $calculator) {
            $currentTotal = $calculator->getTotal($this->remainingItems);
            if ($currentTotal->getSum() != 0) {
                $totals[] = $currentTotal;
            }
            $this->remainingItems = $currentTotal->getRemainingItems();
        }

        return $totals;
    }
}
