<?php

namespace Supermarket\Application\Calculator;

use Supermarket\Model\CartItem;
use Supermarket\Model\Total;

interface Calculator
{
    /**
     * @param CartItem[] $item
     *
     * @return Total
     */
    public function getTotal(array $item): Total;
}
