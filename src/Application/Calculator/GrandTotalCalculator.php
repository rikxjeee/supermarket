<?php

namespace Supermarket\Application\Calculator;

use Supermarket\Model\Cart;
use Supermarket\Model\CartItem;
use Supermarket\Model\Total;

class SandwichMenuDiscountCalculator
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
            $sum += $calculator->getTotal($cart)->getSum();
        }
        $totals[] = new Total('Grand total', $sum);

        foreach ($this->calculators as $calculator) {
            $totals[] = $calculator->getTotal($cart);
            $this->remainingItems = $calculator->getTotal($cart);
        }

        return $totals;
    }
}
